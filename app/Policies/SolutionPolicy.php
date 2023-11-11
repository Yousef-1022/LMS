<?php

namespace App\Policies;

use App\Models\Solution;
use App\Models\User; 
use App\Models\Task;
use Illuminate\Auth\Access\Response;

class SolutionPolicy
{
    
    public function access(User $user, Task $task): bool
    {
        $students = $task->course->students;
        foreach ($students as $student) {
            if ($student->id === $user->id) {
                // User is a student who has registered for the course
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Solution $solution): bool
    {
        return $user->id === $solution->student_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Solution $solution): bool
    {
        return $user->id === $solution->student_id;
    }

      /**
     * Determine whether the user is a teacher and can update the task.
     */
    public function evaluator(User $user, Solution $solution): bool
    {
        return $user->id === $solution->task->course->user_id;
    }
}
