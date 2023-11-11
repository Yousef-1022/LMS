@extends('layouts.main')

@section('title', 'Course page')

@section('content')

<div class="container py-3">
  <div class="d-flex justify-content-between align-items-center">
    <h2>Course details</h2>
    <div>
      <a href="{{ route('courses.tasks.create', ['course' => $course->id]) }}" class="btn btn-primary btn-success">Add new task</a>
      <form action="/courses/{{ $course->id }}" method="post" style="display: inline-block">
        @csrf
        @method("delete")
        <button type="submit" class="btn btn-secondary btn-danger">Delete</button>
      </form>
    </div>
  </div>
  <br>

  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <img src="{{ $course->image_url ?: asset('images/ik_logo.jpg') }}" class="img-fluid">
      </div>
      <div class="col-md-8">
        <h1>{{ $course["name"] }}</h1>
        <p>{{ $course["description"] }}</p>
        <p><strong>Code:</strong> {{ $course["code"] }}</p>
        <p><strong>Credit:</strong> {{ $course["credit"] }}</p>
        <p><strong>Number of students:</strong> {{ count($students) }}</p>
        <p><strong>Date of creation:</strong> {{ $course["created_at"] }}</p>
        <p><strong>Last modification:</strong> {{ $course["updated_at"] }}</p>
      </div>
    </div>
  </div>

  <div class="container mt-4">
    <h2>Registered Students</h2>
    <div class="form-group">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          View
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="overflow-y: auto; max-height: 300;">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $student)
              <tr>
                <td>{{ $student['name'] }}</td>
                <td>{{ $student['email'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <hr>
</div>

<div class="container mt-4">
  <h2>Tasks</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Points</th>
        @if (Auth::user()->is_teacher && Auth::user()->id === $course->user_id)
        <th>Actions</th>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach ($course->tasks as $task)
      <tr>
        <td>
          <a href="{{ route('tasks.show', ['task' => $task->id]) }}" class="task-link">{{ $task['name'] }}</a>
        </td>
        <td>{{ $task['description'] }}</td>
        <td>{{ $task['points'] }}</td>
        @if (Auth::user()->is_teacher && Auth::user()->id === $course->user_id)
        <td>
          <div class="d-flex flex-row align-items-center">
            <a href="{{ route('tasks.edit', ['task' => $task->id]) }}" class="btn btn-sm btn-primary mr-1">Edit</a>
            <div>
              <form action="{{ route('tasks.destroy', ['task' => $task['id']]) }}" method="post" class="d-inline">
                @csrf
                @method('delete')
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<br>

<style>
  .task-link {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
  }

  .task-link:hover {
    text-decoration: underline;
  }

  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 0;
  }

  .table {
    margin-bottom: 0;
  }

  th,
  td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
  }

  th {
    background-color: #f2f2f2;
    color: #333;
  }

  tbody tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  tbody tr:hover {
    background-color: #ddd;
  }

  .dropdown-menu {
    padding: 0;
    max-height: 200px;
    overflow-y: auto;
  }
</style>
@endsection