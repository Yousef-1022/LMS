<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {  
    return view('main'); //main.blade.php
});

Route::get('/contact', function () {  
    return view('contact'); //main.blade.php
});




Route::resource('courses', CourseController::class)->middleware('auth');
Route::resource('courses.tasks', TaskController::class)->shallow()->middleware('auth');
Route::resource('tasks.solutions', SolutionController::class)->shallow()->middleware('auth');

Route::delete('/courses/{course}/leave', [CourseController::class, 'leave'])->name('courses.leave');
Route::get('courses.available', [CourseController::class,'available'])->name('courses.available');
Route::post('courses.available', [CourseController::class,'enroll'])->name('courses.enroll');

Route::get('/solutions/{solution}/evaluate', [SolutionController::class, 'evaluate'])->name('solutions.evaluate');
Route::put('/solutions/{solution}/evaluate', [SolutionController::class, 'score'])->name('solutions.score');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//  Unused
//Route::get('/courses', [CourseController::class, "index"]);
//Route::get('/courses/create', [CourseController::class, "create"])->name('courses.create');
//Route::get('/courses/{course}', [CourseController::class, "show"]);
//Route::get('/courses/{course}/edit', [CourseController::class, "edit"]);
//Route::put('/courses/{course}', [CourseController::class, "update"]);
//Route::delete('/courses/{course}', [CourseController::class, "destroy"]);
//Route::post('/courses/create', [CourseController::class, "store"]);
//Route::resource('tasks', TaskController::class)->middleware('auth');
//Route::post('/courses/{course}/tasks', [TaskController::class, 'store'])->name('courses.tasks.store');
//Route::post('/courses/{course}/tasks', [TaskController::class, 'store'])->name('courses.tasks.store');
//Route::resource('tasks', TaskController::class)->shallow()->middleware('auth');