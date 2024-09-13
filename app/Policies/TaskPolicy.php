<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function edit(User $user, Task $task): Response
    {
        return $user->id === $task->user_id || $user->role === 'admin' ?
         Response::allow() : 
         Response::deny('You are not allowed to modify this task');
    }

    public function modify(User $user, Task $task): Response
    {
        return $user->role === 'admin' ? 
        Response::allow() : 
        Response::deny('You are not authorized.');
    }
}
