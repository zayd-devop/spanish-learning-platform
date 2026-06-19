<?php

namespace App\Http\Controllers;

use App\Models\Week;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function index()
    {
        $weeks = Week::orderBy('week_number', 'asc')->get();
        
        $totalMinutesLogged = 0;
        $totalTasks = 0;
        $completedTasks = 0;
        $currentWeekIndex = 0;
        $weeklyVelocity = 0;

        foreach ($weeks as $week) {
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
        $week = Week::findOrFail($id);
        $week->is_completed = !$week->is_completed;
        $week->save();

        return response()->json([
            'message' => 'Week status updated successfully',
            'week' => $week
        ]);
    }

    public function updateChecklist(Request $request, $id)
    {
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

        $week = Week::findOrFail($id);
        $progress = $week->task_progress ?? [];
        
        $idx = $request->taskIndex;
        if (!isset($progress[$idx])) {
            $progress[$idx] = 0;
        }
        $progress[$idx] += $request->minutes;
        
        $week->task_progress = $progress;
        $week->save();

        return response()->json([
            'message' => 'Time logged successfully',
            'week' => $week
        ]);
    }

    public function resetProgress($id)
    {
        $week = Week::findOrFail($id);
        $week->task_progress = null;
        $week->save();

        return response()->json([
            'message' => 'Progress reset successfully',
            'week' => $week
        ]);
    }

    public function resetTaskProgress($weekId, $taskIndex)
    {
        $week = Week::findOrFail($weekId);
        $progress = $week->task_progress ?? [];
        $progress[$taskIndex] = 0;
        
        $week->task_progress = $progress;
        $week->save();

        return response()->json([
            'message' => 'Task progress reset successfully',
            'week' => $week
        ]);
    }

    public function progress()
    {
        $total = Week::count();
        $completed = Week::where('is_completed', true)->count();
        
        return response()->json([
            'total' => $total,
            'completed' => $completed,
            'percentage' => $total > 0 ? round(($completed / $total) * 100) : 0
        ]);
    }
}
