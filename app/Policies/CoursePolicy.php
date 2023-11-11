<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function access(User $user, Course $course): bool
    {
        if ($user->id === $course->user_id) {
            // User is the teacher who owns the course
            return true;
        }
        $students = $course->students;
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
    public function update(User $user, Course $course): bool
    {
        return $user->is_teacher && $user->id === $course->user_id;
    }
    
    ///**
    // * Determine whether the user can view any models.
    // */
    //public function viewAny(User $user): bool
    //{
    //    //
    //}
//
//
    ///**
    // * Determine whether the user can create models.
    // */
    //public function create(User $user): bool
    //{
    //    //
    //}

    ///**
    // * Determine whether the user can delete the model.
    // */
    //public function delete(User $user, Course $course): bool
    //{
    //    //
    //}
//
    ///**
    // * Determine whether the user can restore the model.
    // */
    //public function restore(User $user, Course $course): bool
    //{
    //    //
    //}
//
    ///**
    // * Determine whether the user can permanently delete the model.
    // */
    //public function forceDelete(User $user, Course $course): bool
    //{
    //    //
    //}
}
