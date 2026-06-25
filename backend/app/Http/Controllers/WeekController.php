<?php

namespace App\Http\Controllers;

use App\Models\Week;
use App\Models\UserWeekProgress;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function index(Request $request)
    {
        $path = $request->query('path', 'standard');
        $weeks = Week::where('path', $path)->orderBy('week_number', 'asc')->get();
        
        $userId = $request->user()->id;
        $progressRecords = UserWeekProgress::where('user_id', $userId)->get()->keyBy('week_id');

        $totalMinutesLogged = 0;
        $totalTasks = 0;
        $completedTasks = 0;
        $currentWeekIndex = 0;
        $weeklyVelocity = 0;

        foreach ($weeks as $week) {
            $userProgress = $progressRecords->get($week->id);
            $week->is_completed = $userProgress ? $userProgress->is_completed : false;
            $week->task_progress = $userProgress ? $userProgress->task_progress : [];

            $checklist = $week->checklist ?? [];
            $progress = $week->task_progress ?? [];
            if (!is_array($checklist)) $checklist = [];
            if (!is_array($progress)) $progress = [];

            $weekCompletedTasks = 0;

            foreach ($checklist as $i => $item) {
                $totalTasks++;
                $goal = is_array($item) && isset($item['weekly_goal_minutes']) ? $item['weekly_goal_minutes'] : 0;
                $logged = isset($progress[$i]) ? $progress[$i] : 0;
                $totalMinutesLogged += $logged;
                
                if ($goal > 0 && $logged >= $goal) {
                    $completedTasks++;
                    $weekCompletedTasks++;
                }
            }

            if ($weekCompletedTasks < count($checklist) && $currentWeekIndex === 0) {
                $currentWeekIndex = $week->week_number;
                $weeklyVelocity = $weekCompletedTasks;
            }
        }

        if ($currentWeekIndex === 0) {
            $currentWeekIndex = 13;
        }

        $milestone = 'A1 Foundation';
        if ($currentWeekIndex >= 11) $milestone = 'B2 Advanced';
        elseif ($currentWeekIndex >= 7) $milestone = 'B1 Intermediate';
        elseif ($currentWeekIndex >= 4) $milestone = 'A2 Beginner';

        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        $kpi = [
            'totalMinutes' => $totalMinutesLogged,
            'completionRate' => $completionRate,
            'weeklyVelocity' => $weeklyVelocity,
            'milestone' => $milestone,
            'currentWeek' => $currentWeekIndex
        ];

        return response()->json([
            'weeks' => $weeks,
            'kpi' => $kpi
        ]);
    }

    public function show($id)
    {
        return response()->json(Week::findOrFail($id));
    }

    public function toggleCompletion(Request $request, $id)
    {
        $userId = $request->user()->id;
        $week = Week::findOrFail($id);
        
        $progress = UserWeekProgress::firstOrCreate(
            ['user_id' => $userId, 'week_id' => $week->id],
            ['is_completed' => false, 'task_progress' => []]
        );
        
        $progress->is_completed = !$progress->is_completed;
        $progress->save();

        $week->is_completed = $progress->is_completed;
        $week->task_progress = $progress->task_progress;

        return response()->json([
            'message' => 'Week status updated successfully',
            'week' => $week
        ]);
    }

    public function updateChecklist(Request $request, $id)
    {
        // Deprecated or rarely used, but we keep the structure just in case.
        // It updates the global week model which might be wrong, but it's not standard progress.
        $request->validate([
            'completed_checklists' => 'array'
        ]);

        $week = Week::findOrFail($id);
        $week->completed_checklists = $request->completed_checklists ?? [];
        $week->save();

        return response()->json([
            'message' => 'Checklist updated successfully',
            'week' => $week
        ]);
    }

    public function logTime(Request $request, $id)
    {
        $request->validate([
            'taskIndex' => 'required|integer',
            'minutes' => 'required|integer'
        ]);

        $userId = $request->user()->id;
        $week = Week::findOrFail($id);
        
        $progress = UserWeekProgress::firstOrCreate(
            ['user_id' => $userId, 'week_id' => $week->id],
            ['is_completed' => false, 'task_progress' => []]
        );

        $taskProgress = $progress->task_progress ?? [];
        $idx = $request->taskIndex;
        if (!isset($taskProgress[$idx])) {
            $taskProgress[$idx] = 0;
        }
        $taskProgress[$idx] += $request->minutes;
        
        $progress->task_progress = $taskProgress;
        $progress->save();

        $week->is_completed = $progress->is_completed;
        $week->task_progress = $progress->task_progress;

        return response()->json([
            'message' => 'Time logged successfully',
            'week' => $week
        ]);
    }

    public function resetProgress(Request $request, $id)
    {
        $userId = $request->user()->id;
        $week = Week::findOrFail($id);
        
        $progress = UserWeekProgress::where('user_id', $userId)->where('week_id', $week->id)->first();
        if ($progress) {
            $progress->task_progress = null;
            $progress->save();
        }

        $week->is_completed = $progress ? $progress->is_completed : false;
        $week->task_progress = null;

        return response()->json([
            'message' => 'Progress reset successfully',
            'week' => $week
        ]);
    }

    public function resetTaskProgress(Request $request, $weekId, $taskIndex)
    {
        $userId = $request->user()->id;
        $week = Week::findOrFail($weekId);
        
        $progress = UserWeekProgress::where('user_id', $userId)->where('week_id', $week->id)->first();
        if ($progress) {
            $taskProgress = $progress->task_progress ?? [];
            $taskProgress[$taskIndex] = 0;
            $progress->task_progress = $taskProgress;
            $progress->save();
        }

        $week->is_completed = $progress ? $progress->is_completed : false;
        $week->task_progress = $progress ? $progress->task_progress : [];

        return response()->json([
            'message' => 'Task progress reset successfully',
            'week' => $week
        ]);
    }

    public function progress(Request $request)
    {
        $userId = $request->user()->id;
        $total = Week::count();
        $completed = UserWeekProgress::where('user_id', $userId)->where('is_completed', true)->count();
        
        return response()->json([
            'total' => $total,
            'completed' => $completed,
            'percentage' => $total > 0 ? round(($completed / $total) * 100) : 0
        ]);
    }
}
