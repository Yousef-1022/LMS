<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\Solution;

class SolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::all();
        $students = User::where('is_teacher', false)->get();
        foreach ($students as $student) {
            $courses = $student->courses;

            foreach ($courses as $course) {
                $tasks = $course->tasks;
                $randomTasks = $tasks->random(rand(1,count($tasks)));
                
                foreach ($randomTasks as $task) {
                    $evaluated = fake()->boolean();
                    $result = $evaluated ? fake()->numberBetween($min = 0, $max = $task->points) : 0;
                    $solution = Solution::factory()->create([
                        'task_id' => $task->id,
                        'student_id' => $student->id,
                        'evaluated' => $evaluated,
                        'result' => $result,
                    ]);
                }
            }

        }
    }
}
