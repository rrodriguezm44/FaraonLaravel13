<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('task', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'description' => $request->description,
        ]);

        broadcast(new TaskCreated($task));

        return response()->json([
            'success' => true,
            'task' => [
                'id' => $task->id,
                'description' => $task->description,
                'created_at' => $task->created_at,
            ]
        ]);
    }
}
