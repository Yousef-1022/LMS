@extends('layouts.main')


@section('content')

@if (session('info'))
<div class="alert alert-info">
  {{ session('info') }}
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
            <a href="{{ route('tasks.show', ['task' => $task]) }}" class="btn btn-secondary">Back to Task</a>
        </div>
    </div>

    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Submitted answer:</h4>
        </div>
        <div class="solution-box p-3 mb-3">
            <p>{{ $solution->answer }}</p>
        </div>
        <div class="text-muted">
            <p class="mb-0"><strong>Student:</strong> {{ auth()->user()->getNameById($solution->student_id) }}</p>
            <p><strong>Submitted at:</strong> {{ $solution->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
        <form action="{{ route('solutions.score', $solution) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="result">Enter a value between 0 and {{$task->points}}</label>
                <input type="number" class="form-control @error('result') is-invalid @enderror" name="result" placeholder="" value="{{ old('result', '') }}" min="0" max="{{$task->point}}" required>
                @error('result')
                <div class="invalid-feedback">
                    The value must be between 0 and {{$task->points}}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>

</div>





<style>
    .solution-box {
        background-color: #f2f2f2;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .solution-box p {
        font-size: 18px;
        line-height: 1.5;
        color: #333;
    }

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