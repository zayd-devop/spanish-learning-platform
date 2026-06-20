<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Grado;

class AiController extends Controller
{
    private function callGemini($prompt, $audioBase64 = null, $audioMimeType = null)
    {
        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            return [
                'error' => true,
                'message' => 'GEMINI_API_KEY is not set in the .env file.',
            ];
        }

        // Remove surrounding quotes if they exist in the env variable
        $apiKey = trim($apiKey, "'\"");
        
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent";

        try {
            $parts = [['text' => $prompt]];
            if ($audioBase64 && $audioMimeType) {
                $parts[] = [
                    'inline_data' => [
                        'mime_type' => $audioMimeType,
                        'data' => $audioBase64
                    ]
                ];
            }

            // Disable SSL verification for local Windows environments (Fixes cURL error 60)
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'x-goog-api-key' => $apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post($url, [
                'contents' => [
                    [
                        'parts' => $parts
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return [
                        'error' => false,
                        'text' => $data['candidates'][0]['content']['parts'][0]['text']
                    ];
                }
            }

            return [
                'error' => true,
                'message' => 'Failed to get a response from Gemini API: ' . $response->body()
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Connection Error: ' . $e->getMessage()
            ];
        }
    }

    public function enhanceText(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'context' => 'nullable|string'
        ]);

        $prompt = "You are an expert resume writer. Please enhance the following text to sound more professional, concise, and impactful for a Software Developer resume. " . 
                  ($validated['context'] ? "Context: {$validated['context']}. " : "") . 
                  "Do not include any intro or outro, just return the enhanced text itself.\n\nText: " . $validated['text'];

        $result = $this->callGemini($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json(['enhanced_text' => trim($result['text'])]);
    }

    public function analyzeCv(Request $request)
    {
        $validated = $request->validate([
            'cv_text' => 'required|string'
        ]);

        $grados = Grado::all();
        $gradosList = $grados->map(function($g) {
            return "- ID: {$g->id}, Name: {$g->name}, Institute: {$g->institute}";
        })->join("\n");

        $prompt = "You are an expert academic advisor in Spain. Analyze the following developer CV and compare it to these Vocational Training Degrees (Grados Superiores). Assign a 'match score' (0-100) to each Grado.
        
Return ONLY a strictly valid JSON array of objects. Do not use markdown blocks like ```json.
The JSON must look EXACTLY like this structure:
[
  { \"grado_id\": 1, \"score\": 90, \"reason\": \"Strong web skills match DAW.\" },
  { \"grado_id\": 2, \"score\": 60, \"reason\": \"Lacks Java experience for DAM.\" }
]

Grados:
{$gradosList}

CV:
{$validated['cv_text']}";

        $result = $this->callGemini($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        // Log the raw response for debugging!
        \Illuminate\Support\Facades\Log::info("RAW GEMINI CV RESPONSE: " . $result['text']);

        // Clean up markdown if the model accidentally included it
        $jsonStr = str_replace(['```json', '```'], '', trim($result['text']));
        
        $scores = json_decode($jsonStr, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to parse AI response as JSON: ' . $jsonStr], 500);
        }

        // Handle case where Gemini returns { "scores": [...] } instead of [...]
        if (isset($scores['scores']) && is_array($scores['scores'])) {
            $scores = $scores['scores'];
        }

        return response()->json(['scores' => $scores]);
    }

    private function extractTextFromPdf($file)
    {
        if (!class_exists(\Smalot\PdfParser\Parser::class)) {
            throw new \Exception('smalot/pdfparser is not installed. Please run composer require smalot/pdfparser');
        }

        $parser = new \Smalot\PdfParser\Parser();
        $pdf    = $parser->parseFile($file->getPathname());
        return $pdf->getText();
    }

    public function extractPdfText(Request $request)
    {
        $request->validate(['cv_pdf' => 'required|file|mimes:pdf']);

        try {
            $text = $this->extractTextFromPdf($request->file('cv_pdf'));
            return response()->json(['text' => $text]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function parseResumePdf(Request $request)
    {
        $request->validate(['cv_pdf' => 'required|file|mimes:pdf']);

        try {
            $text = $this->extractTextFromPdf($request->file('cv_pdf'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $prompt = "You are an expert CV parser. I will give you the raw text of a CV. I need you to extract the information and return ONLY a valid JSON object matching exactly this structure: 
{
  \"personalInfo\": { \"name\": \"\", \"email\": \"\", \"phone\": \"\", \"summary\": \"\" },
  \"experience\": [ { \"company\": \"\", \"role\": \"\", \"description\": \"\" } ],
  \"education\": [ { \"institution\": \"\", \"degree\": \"\", \"year\": \"\" } ],
  \"skills\": \"comma separated skills\"
}.
Return ONLY JSON, no markdown blocks.

CV Text:
" . $text;

        $result = $this->callGemini($prompt);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        $jsonStr = str_replace(['```json', '```'], '', trim($result['text']));
        $parsed = json_decode($jsonStr, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to parse AI response as JSON.'], 500);
        }

        return response()->json(['resume' => $parsed]);
    }

    public function chatPractice(Request $request)
    {
        $request->validate([
            'message' => 'required_without:audio_data|nullable|string',
            'history' => 'nullable|array',
            'audio_data' => 'nullable|string',
            'mime_type' => 'nullable|string'
        ]);

        $historyStr = "";
        if ($request->has('history') && is_array($request->history)) {
            foreach ($request->history as $msg) {
                $role = isset($msg['role']) && $msg['role'] === 'user' ? 'Student' : 'Tutor';
                $content = isset($msg['content']) ? $msg['content'] : '';
                $historyStr .= "{$role}: {$content}\n";
            }
        }

        $hasAudio = $request->has('audio_data') && $request->has('mime_type');
        $audioBase64 = $hasAudio ? $request->audio_data : null;
        $audioMimeType = $hasAudio ? $request->mime_type : null;
        
        // Strip the data:audio/...;base64, prefix if it exists in audio_data
        if ($hasAudio) {
            $audioBase64 = preg_replace('/^data:audio\/\w+(?:;\w+=[^;]+)*;base64,/', '', $audioBase64);
        }

        $prompt = "You are 'Maestro', a friendly and encouraging native Spanish language tutor. 
Your student is learning Spanish and is currently around a B1 level.
Your rules:
1. ALWAYS reply entirely in Spanish, keeping the vocabulary at a B1/B2 level.
2. If the student makes a grammatical error, politely correct them in Spanish before continuing the conversation.
3. Ask a relevant follow-up question to keep the conversation flowing.
4. Keep your responses relatively short and conversational (2-4 sentences max).

Conversation History:
{$historyStr}\n";

        if ($hasAudio) {
            $prompt .= "The student provided an AUDIO message. Listen to it carefully. 
First, transcribe exactly what the student said in Spanish (prefix with 'Transcripción:'). 
Then, correct any grammatical or pronunciation mistakes they made. 
Finally, provide your conversational response to what they said.";
        } else {
            $prompt .= "Student's latest message: {$request->message}";
        }

        $prompt .= "\n\nTutor's reply:";

        $result = $this->callGemini($prompt, $audioBase64, $audioMimeType);

        if ($result['error']) {
            return response()->json(['error' => $result['message']], 500);
        }

        return response()->json(['reply' => trim($result['text'])]);
    }
}
