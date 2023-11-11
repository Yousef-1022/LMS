<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Solution;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->is_teacher
            ? $this->hasMany(Course::class)
            : $this->belongsToMany(Course::class);
    }

    public function getNameById($id)
    {
        $user = User::findOrFail($id);
        return $user->name;    
    }

    public function getOwnedSolutionsForCourse($course)
    {
        $courseId = $course->id;
        // Retrieve all the solutions for the given course that belong to the user
        return Solution::where('student_id', $this->id)
            ->whereHas('task.course', function ($query) use ($courseId) {
                $query->where('id', $courseId);
            })
            ->get();
    }

    public function getOwnedSolutionForTask($task) 
    {
        $taskId = $task->id;
        //  Retreive the solution for the specific task
        $sols = $this->getOwnedSolutionsForCourse($task->course);
        return $sols->where('task_id', $taskId)->first();
    }

    public function doesASolutionExistForTask($task) 
    {
        return (bool) $this->getOwnedSolutionForTask($task)?->answer;
    }

}
