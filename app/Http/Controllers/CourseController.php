<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseFormRequest;
use App\Rules\RedundantCourseCode;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;


class CourseController extends Controller
{
    public function index()
    {
        $courses = Auth::user()->courses()->get();   //Course:all();
        return view('courses.list', [
            "courses" => $courses,
        ]);
    }

    public function create()
    {
        if (Auth::user()->is_teacher) {
            return view('courses.create');
        } else {
            return redirect()->route('courses.index')->with('error', 'You cannot publish courses!');
        }
    }

    public function store(CourseFormRequest $request)
    {
        $user = Auth::user();
        if ($user->is_teacher) {
            $courses = $user->courses();
            $courses->create($request->validated());
            return redirect("/courses");
        }
        return redirect()->route('courses.index') > with('error', 'You cannot publish courses!');
    }

    public function edit(Course $course)
    {
        $this->authorize('access', $course);
        return view('courses.edit', [
            "course" => $course,
        ]);
    }
    public function update(Request $request, Course $course)
    {
        $this->authorize('access', $course);
        //$course->update($request->validated());
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'required',
            'code' => new RedundantCourseCode($course->code),
            'credit' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
        ]);
        $course->update($validated);
        return redirect("/courses");
    }

    public function show(Course $course)
    {
        $this->authorize('access', $course);
        $user = Auth::user();

        $studentIds = $course->students()->pluck('user_id')->toArray();
        $students = \App\Models\User::whereIn('id', $studentIds)->get(['name', 'email'])->toArray();
        $is_student = $course->students()->where('user_id', $user->id)->exists();
        
        if ($is_student) {
            $teacherId = $course->user_id;
            $teacher = \App\Models\User::whereIn('id', [$teacherId])->first();
            return view('courses.student_show', [
                "course" => $course,
                "students" => $students,
                "teacher_name" => $teacher->name,
                "teacher_email" => $teacher->email
            ]);
        }

        return view('courses.show', [
            "course" => $course,
            "students" => $students,
        ]);
    }

    public function destroy(Course $course)
    {
        $this->authorize('access', $course);
        $course->delete();
        return redirect("/courses");
    }

    //  Student specific
    public function leave(Course $course)
    {
        $user = Auth::user();
        $isAStudent = $course->students()->where('user_id', $user->id)->exists();
        if ($isAStudent) {
            //  Remove student
            $course->students()->detach($user);
            //  Remove solutions
            $sols = $user->getOwnedSolutionsForCourse($course);
            $sols->each->delete();
            return redirect()->route('courses.index')->with('drop', 'You have successfully dropped out of the course: ' . $course->code);
        }
        return redirect()->route('courses.index')->with('error', 'ERROR DROPPING ' . $course->code . ' !!!');
    }

    public function available()
    {
        $user = Auth::user();
        if ($user->is_teacher) {
            return redirect()->route('courses.index')->with('info', 'You cannot view the courses of others.');
        }
        $courses = Course::all();
        $enrolledCourseIds = $user->courses()->pluck('course_id');
        $courses = Course::whereNotIn('id', $enrolledCourseIds)->get();
        return view('courses.available', [
            "courses" => $courses,
        ]);
    }

    public function enroll(Request $request)
    {
        $user = Auth::user();
        if ($user->is_teacher) {
            return redirect()->route('courses.index') > with('info', 'You are a teacher! You cannot enroll into your own course.');
        }
        $course = Course::findOrFail($request->input('course_id'));
        $course->students()->attach($user);
        return redirect()->route('courses.index')->with('success', 'You have successfully enrolled into the course: ' . $course->code);
    }
}
