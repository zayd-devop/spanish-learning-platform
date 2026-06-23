<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserData;
use Illuminate\Support\Facades\Auth;

class UserDataController extends Controller
{
    public function getData(Request $request)
    {
        $user = Auth::user();
        $userData = UserData::firstOrCreate(['user_id' => $user->id]);
        
        return response()->json($userData);
    }

    public function updateData(Request $request)
    {
        $request->validate([
            'documents_data' => 'nullable|array',
            'budget_data' => 'nullable|array',
            'practice_chat_history' => 'nullable|array',
            'interview_history' => 'nullable|array',
        ]);

        $user = Auth::user();
        $userData = UserData::firstOrCreate(['user_id' => $user->id]);

        // Only update fields that are present in the request
        if ($request->has('documents_data')) {
            $userData->documents_data = $request->input('documents_data');
        }
        if ($request->has('budget_data')) {
            $userData->budget_data = $request->input('budget_data');
        }
        if ($request->has('practice_chat_history')) {
            $userData->practice_chat_history = $request->input('practice_chat_history');
        }
        if ($request->has('interview_history')) {
            $userData->interview_history = $request->input('interview_history');
        }

        $userData->save();

        return response()->json(['success' => true, 'data' => $userData]);
    }
}
