<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::where('role', '!=', 'admin')->with('tasks')->get();

        $users->each(function ($user) {
            $user->pendingTasksCount = $user->tasks->where('status', 'pending')->count();
            $user->inProgressTasksCount = $user->tasks->where('status', 'in_progress')->count();
            $user->completedTasksCount = $user->tasks->where('status', 'completed')->count();
            $user->totalTasksCount = $user->tasks->count();
        });

        return view('users.index', compact('users'));
    }
}
