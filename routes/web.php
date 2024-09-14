<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Task $tasks, User $users) {

    if (Auth::user()->role === 'admin') {
        $tasks->pendingTasksCount = $tasks->where('status', 'pending')->count();
        $tasks->inProgressTasksCount = $tasks->where('status', 'in_progress')->count();
        $tasks->completedTasksCount = $tasks->where('status', 'completed')->count();
        $tasks->totalTasksCount = $tasks->count();

        $users = User::where('role', '!=', 'admin')->with('tasks')->get();
    } else {
        // Filter tasks based on the logged-in user
        $tasks->pendingTasksCount = $tasks->where('user_id', Auth::id())->where('status', 'pending')->count();
        $tasks->inProgressTasksCount = $tasks->where('user_id', Auth::id())->where('status', 'in_progress')->count();
        $tasks->completedTasksCount = $tasks->where('user_id', Auth::id())->where('status', 'completed')->count();
        $tasks->totalTasksCount = $tasks->where('user_id', Auth::id())->count();

        $users = []; // No need to fetch users for non-admin
    }

    return view('dashboard', compact('tasks', 'users'));

})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //USERS
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

Route::resource('tasks', TaskController::class);

require __DIR__.'/auth.php';
