<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SubmissionController extends Controller
{
    public function store(Request $request, $weekId)
    {
        $request->validate([
            'text_answer' => 'nullable|string',
            'audio' => 'nullable|file|mimes:webm,mp3,wav,ogg,mp4,m4a', // browser recorders often use webm/mp4
        ]);

        if (empty($request->text_answer) && !$request->hasFile('audio')) {
            return response()->json(['message' => 'Please provide text or audio.'], 400);
        }

        $week = Week::findOrFail($weekId);

        $audioPath = null;
        $audioMimeType = null;
        $audioBase64 = null;

        if ($request->hasFile('audio')) {
            $file = $request->file('audio');
            $audioPath = $file->store('audio', 'public');
            $audioMimeType = $file->getMimeType();
            $audioBase64 = base64_encode(file_get_contents($file->getRealPath()));
        }

        // Call Gemini API
        $apiKey = env('GEMINI_API_KEY');
        $evaluationScore = 0;
        $evaluationFeedback = "Evaluation failed.";

        if (empty($apiKey)) {
            $evaluationScore = rand(5, 10);
            $evaluationFeedback = "This is a mock AI evaluation (API Key missing). Your vocabulary was generally good. Try to focus on the pronunciation of your 'R's and ensure your verb conjugations in the preterite are accurate. Specifically, watch out for the irregular forms like 'fui' vs 'fue'.";
        } else {
            $prompt = "You are a strict but encouraging Spanish language teacher evaluating a student's milestone submission.\n";
            $prompt .= "The milestone target is: '{$week->milestone}'.\n";
            
            if ($request->text_answer) {
                $prompt .= "The student provided the following text: '{$request->text_answer}'.\n";
            }
            if ($audioBase64) {
                $prompt .= "The student also provided an audio recording (attached).\n";
            }
            
            $prompt .= "Please evaluate their submission strictly based on their vocabulary, grammar, and pronunciation (if audio is provided). Be highly critical but constructive.\n";
            $prompt .= "Return your evaluation strictly in JSON format with exactly two keys:\n";
            $prompt .= "1. 'score': an integer from 1 to 10.\n";
            $prompt .= "2. 'feedback': A detailed string explaining what they did well and what they need to improve (written in English but quoting their Spanish errors).\n";

            $parts = [
                ['text' => $prompt]
            ];

            if ($audioBase64) {
                $parts[] = [
                    'inlineData' => [
                        'mimeType' => 'audio/webm',
                        'data' => $audioBase64
                    ]
                ];
            }

            $payload = [
                'contents' => [
                    [
                        'parts' => $parts
                    ]
                ],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                ]
            ];

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                        $jsonText = $data['candidates'][0]['content']['parts'][0]['text'];
                        $evalData = json_decode($jsonText, true);

                        if ($evalData && isset($evalData['score']) && isset($evalData['feedback'])) {
                            $evaluationScore = (int) $evalData['score'];
                            $evaluationFeedback = $evalData['feedback'];
                        } else {
                            $evaluationFeedback = "Error: Invalid JSON format returned from AI.";
                        }
                    } else {
                        $evaluationFeedback = "Error: Unexpected API response format.";
                        Log::error("Gemini API Error structure:", $data);
                    }
                } else {
                    $evaluationFeedback = "Error calling AI API: " . $response->body();
                    Log::error("Gemini API Request Failed:", ['status' => $response->status(), 'body' => $response->body()]);
                }
            } catch (\Exception $e) {
                $evaluationFeedback = "Exception calling AI API: " . $e->getMessage();
                Log::error("Gemini API Exception: " . $e->getMessage());
            }
        }

        $submission = Submission::create([
            'week_id' => $week->id,
            'text_answer' => $request->text_answer,
            'audio_path' => $audioPath,
            'evaluation_score' => $evaluationScore,
            'evaluation_feedback' => $evaluationFeedback,
        ]);

        return response()->json([
            'message' => 'Submission received and evaluated successfully!',
            'submission' => $submission
        ]);
    }
}
