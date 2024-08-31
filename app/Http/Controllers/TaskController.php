<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|unique:tasks,task|max:255',
        ]);

        Task::create([
            'task' => $request->task,
        ]);

        return response()->json(['success' => 'Task added successfully']);
    }

    public function update(Task $task)
    {
        $task->update(['is_completed' => true]);

        return response()->json(['success' => 'Task updated successfully']);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['success' => 'Task deleted successfully']);
    }
}
