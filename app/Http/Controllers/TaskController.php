<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskFor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('taskFor')->get();
        return view('dashboard', compact('tasks'));
    }
    
    public function addtasks()
    {
        $users = User::all();
        return view('add-tasks', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'task_for' => 'required|array',
        ]);

        
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => 0,
        ]);

        foreach ($request->task_for as $user_id) {
            TaskFor::create([
                'task_id' => $task->id,
                'task_for' => $user_id,
            ]);
        }

        
        return redirect()->route('dashboard')->with('success', 'Task created and assigned successfully!');
    }

    public function completeTask($id)
    {
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to login first.');
        }

        
        $task = Task::findOrFail($id);
        $task->is_completed = 1; 
        $task->save();

        return redirect()->route('dashboard')->with('success', 'Task completed successfully.');
    }
}
