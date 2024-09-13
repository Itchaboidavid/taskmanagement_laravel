<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $tasks = $user->isAdmin()
        ? Task::with('user')->latest()->get()
        : Task::where('user_id', $user->id)->with('user')->latest()->get();
        
        return view('tasks.index', ['tasks' => $tasks, 'user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if(!$user->isAdmin()) {
            return back() ;
        }
        
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'user_id' => 'required|exists:users,id'
        ]);

        $task = Task::create($formData);

        return redirect()->route('tasks.index')->with('status', 'Task was created successfully') ;
    }

    /**
     * Display the specified resource.x`
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        Gate::authorize('edit', $task);
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        Gate::authorize('edit', $task);

        $formData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'user_id' => 'required|exists:users,id'
        ]);

        $task->update($formData);

        return redirect()->route('tasks.index')->with('status', 'Task was updated successfully') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('modify', $task);
        
        $task->delete();

        return redirect(route('tasks.index'));
    }
}
