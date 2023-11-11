<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Course;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        $this->authorize('access', $course);
        return view("tasks.create", [
            "course" => $course
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Course $course, StoreTaskRequest $request)
    {
        $this->authorize('access', $course);
        $course->tasks()->create($request->validated());
        return redirect()->route("courses.show", ["course" => $course->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('viewAny', $task);
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('access', $task);
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        $this->authorize('access', $task);
        $task->update($request->validated());
        return redirect()->route('courses.show', ['course' => $task->course['id']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('access', $task);
        $task->delete();
        return redirect()->route('courses.show', ['course' => $task->course['id']]);
    }
}
