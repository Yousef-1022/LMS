@extends('layouts.main')

@section('title', 'Edit task')

@section('content')

<div class="container py-3">
  <h2>Edit task</h2>
  <form action="{{ route('tasks.update', ['task' => $task['id']]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="name">Task name</label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $task['name']) }}">
      @error('name')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $task['description']) }}</textarea>
      @error('description')
      <div class="invalid-feedback">
        Please choose a description for the task.
      </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="points">Points</label>
      <input value="{{ old('points',$task['points']) }}" name="points" type="text" class="form-control @error('points') is-invalid @enderror" id="points" placeholder="">
      @error('points')
      <div class="invalid-feedback">
        Please choose a valid number for the points.
      </div>
      @enderror
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Update task</button>
    </div>

  </form>
</div>

@endsection