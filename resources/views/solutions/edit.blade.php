@extends('layouts.main')

@section('title', $task->name)

@section('content')
<div class="container py-3">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">{{ $task->name }}</h2>
    </div>
    <div class="card-body">
      <p class="card-text">{{ $task->description }}</p>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <p><strong>Course:</strong> {{ $task->course->name }}</p>
        </div>
        <div class="col-md-6">
          <p class="text-md-right"><strong>Points:</strong> {{ $task->points }}</p>
        </div>
      </div>
      <form action="{{ route('solutions.update' , $solution) }}" method="post">
        @csrf
        @method('PUT')
        <label for="solution">Your Solution:</label>
        <textarea class="form-control @error('answer') is-invalid @enderror" name="answer" rows="3">{{ old('answer', $solution['answer']) }}</textarea>
        @error('answer')
        <div class="invalid-feedback">
          There must be a solution submitted!
        </div>
        @enderror
        <br>
        <button type="submit" class="btn btn-success">Update</button>
      </form>
    </div>
    <div class="card-footer">
      <a href="{{ route('courses.show', ['course' => $task->course->id]) }}" class="btn btn-secondary">Back to Course</a>
    </div>
  </div>
</div>


<style>
  .card {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
  }

  .card-header {
    background-color: #f7f7f7;
    border-bottom: none;
  }

  .card-title {
    font-size: 2rem;
    font-weight: bold;
    margin: 0;
  }

  .card-body {
    padding: 1.5rem;
  }

  .card-text {
    font-size: 1.2rem;
    line-height: 1.5;
    margin: 0;
  }

  .card-footer {
    background-color: #f7f7f7;
    border-top: none;
    padding: 1.5rem;
    text-align: right;
  }

  .btn-secondary {
    background-color: #007bff;
    border-color: #007bff;
    font-size: 1.2rem;
    font-weight: bold;
    padding: 0.75rem 1.5rem;
  }

  .btn-secondary:hover {
    background-color: #0062cc;
    border-color: #005cbf;
  }
</style>
@endsection