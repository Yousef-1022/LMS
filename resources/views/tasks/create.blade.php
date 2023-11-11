@extends('layouts.main')

@section('title', 'New task page')

@section('content')

<div class="container py-3">
    <h2>New task</h2>
    <form action="{{ route('courses.tasks.store', ['course' => $course->id]) }}" method="POST">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="name">Task name</label>
            <input value="{{ old('name', '') }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="">
            @error('name')
            <div class="invalid-feedback">
                Please choose a task name which is 5 characters or more.
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', '') }}</textarea>
            @error('description')
            <div class="invalid-feedback">
                Please choose a description for the task.
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="points">Points</label>
            <input value="{{ old('points', '') }}" name="points" type="text" class="form-control @error('points') is-invalid @enderror" id="points" placeholder="">
            @error('points')
            <div class="invalid-feedback">
                Please choose a valid number for the points.
            </div>
            @enderror
        </div>


        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add new task</button>
        </div>

    </form>
</div>

@endsection