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

    $tasks->pendingTasksCount = $tasks->where('status', 'pending')->count();
    $tasks->inProgressTasksCount = $tasks->where('status', 'in_progress')->count();
    $tasks->completedTasksCount = $tasks->where('status', 'completed')->count();
    $tasks->totalTasksCount = $tasks->count();

    $users = User::where('role', '!=', 'admin')->with('tasks')->get();
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
