<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function access(User $user, Task $task): bool
    {
        if ($user->id === $task->course->user_id) {
            // User is the teacher who owns the course
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Task $task): bool
    {
        if ($user->id === $task->course->user_id) {
            // User is the teacher who owns the course
            return true;
        }
            // User belongs to the course
        return $task->course->students()->where('user_id', $user->id)->exists();
    }

    public function solCreateAllow(User $user, Task $task): bool
    {
        return $task->course->students()->where('user_id', $user->id)->exists();
    }

}
