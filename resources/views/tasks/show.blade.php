@extends('layouts.main')

@section('title', $task->name)


@section('content')

@if (session('info'))
<div class="alert alert-info">
  {{ session('info') }}
</div>
@elseif (session('drop'))
<div class="alert alert-danger">
  {{ session('drop') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@elseif (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

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
    </div>
    <div class="card-footer">
      <a href="{{ route('courses.show', ['course' => $task->course->id]) }}" class="btn btn-secondary">Back to Course</a>
    </div>
  </div>
</div>

<div class="container py-3">
  <div class="card">
    <div class="card-header">
      @if (auth()->user()->is_teacher)
      <h2 class="card-title">Solutions</h2>
      @else
      <h2 class="card-title">Submitted Solution</h2>
      @endif
    </div>
    <div class="card-body">
      @if (auth()->user()->is_teacher && auth()->user()->id === $task->course->user_id)
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($task->solutions as $solution)
          <tr>
            <td>
              <p><strong>Student name:</strong> {{ auth()->user()->getNameById($solution->student_id) }}</p>
              <p>{{ $solution->answer }}</p>
              <p><strong>Submitted at: {{ $solution->created_at }}</strong></p>
            </td>
            <td>
              @if($solution->evaluated)
              <button type="button" class="btn btn-custom" disabled>Evaluated</button>
              @else
              <a href="{{ route('solutions.evaluate', $solution->id) }}" class="btn btn-primary">Evaluate</a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      @else
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Answer</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ auth()->user()->name }}</td>
            @if( auth()->user()->doesASolutionExistForTask($task) )
            <td>{{ auth()->user()->getOwnedSolutionForTask($task)->answer }}</td>
            <td>
              <div class="btn-group" role="group" aria-label="Solution Actions">
                <a href="{{ route('solutions.edit', ['solution' => auth()->user()->getOwnedSolutionForTask($task)['id']]) }}" class="btn btn-primary"
                onclick="return confirm('Are you sure you want to modify your solution? Previous evaluated result will be disregarded after submitting the change')">Modify</a>
                <form action="{{route('solutions.destroy', ['solution' => auth()->user()->getOwnedSolutionForTask($task)['id']]) }}" method="POST" style="display: inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </div>
            </td>
            @else
            <td>Nothing submitted yet!</td>
            <td>
              <div class="btn-group" role="group" aria-label="Solution Actions">
                <a href="{{ route('tasks.solutions.create', ['task' => $task->id]) }}" class="btn btn-primary">Add</a>
              </div>
            </td>
            @endif
          </tr>
        </tbody>
      </table>

      @endif
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

  .btn-group {
    display: flex;
    justify-content: space-between;
    margin: 0;
    padding: 0;
  }

  .btn {
    font-size: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    cursor: pointer;
  }

  .btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
  }

  .btn-primary:hover {
    background-color: #0062cc;
    border-color: #005cbf;
  }

  .btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
  }

  .btn-custom {
    background-color: #6c757d;
    border-color: #6c757d;
    color: #fff;
    cursor: not-allowed;
    opacity: 0.65;
  }

  .table th,
  .table td {
    padding: 12px;
    text-align: left;
    vertical-align: middle;
    border: 1px solid #dee2e6;
  }

  .table th {
    background-color: #f5f5f5;
    font-weight: bold;
    border-bottom: 2px solid #ddd;
  }

  .table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
  }
</style>
@endsection