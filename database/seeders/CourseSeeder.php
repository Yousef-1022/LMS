<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->truncate();
        DB::table('tasks')->truncate();

        //$teachers = User::where('is_teacher', true)->get();
        //$teachers->each(function ($teacher) {
        //    Course::factory(5)
        //    ->forTeacher($teacher)
        //    ->hasTasks(3)
        //    ->create();
        //});

        $users = User::all();
        $users->each(function ($user) {
            if ($user->is_teacher) {
        
                $courses = Course::factory(2)
                ->forTeacher($user)
                ->hasTasks(3)
                ->create();

                $students = User::where('is_teacher', false)->inRandomOrder()->take(3)->get();
                $courses->each(function ($course) use ($students) {
                    $course->students()->attach($students);
                });
            }
        });

    }
}
