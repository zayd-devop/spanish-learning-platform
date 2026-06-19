<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        // Currently expecting Auth to work, but if API auth is simple:
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->json($user->resumes);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|array',
        ]);

        $resume = $user->resumes()->create($validated);

        return response()->json($resume, 201);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $resume = Resume::where('user_id', $user->id)->findOrFail($id);
        
        return response()->json($resume);
    }
}
