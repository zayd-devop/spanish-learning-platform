<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestSubmission;
use App\Models\Week;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function getWeeklyTest($weekId)
    {
        $test = Test::with('questions')->where('week_id', $weekId)->where('type', 'weekly')->first();
        
        if (!$test) {
            return response()->json(['message' => 'No test available for this week.'], 404);
        }

        // Hide correct answers from the response
        $test->questions->makeHidden(['correct_answer']);

        return response()->json($test);
    }

    public function getFinalTest()
    {
        $test = Test::with('questions')->whereNull('week_id')->where('type', 'final')->first();

        if (!$test) {
            return response()->json(['message' => 'No final test available.'], 404);
        }

        $test->questions->makeHidden(['correct_answer']);

        return response()->json($test);
    }

    public function submitTest(Request $request, $testId)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $test = Test::with('questions')->findOrFail($testId);
        $userAnswers = $request->answers; // e.g. ['question_id' => 'user selected option']

        $correctCount = 0;
        $totalQuestions = $test->questions->count();

        foreach ($test->questions as $question) {
            if (isset($userAnswers[$question->id]) && $userAnswers[$question->id] === $question->correct_answer) {
                $correctCount++;
            }
        }

        $score = $totalQuestions > 0 ? (int)(($correctCount / $totalQuestions) * 100) : 0;

        $submission = TestSubmission::create([
            'test_id' => $test->id,
            'score' => $score,
            'answers' => $userAnswers,
        ]);

        return response()->json([
            'score' => $score,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
            'message' => 'Test submitted successfully!'
        ]);
    }
}
