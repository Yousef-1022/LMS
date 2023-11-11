@extends('layouts.main')

@section('title', 'Listing page')

@section('content')

@if (session('drop'))
<div class="alert alert-info">
  {{ session('drop') }}
</div>
@elseif (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@elseif (session('info'))
<div class="alert alert-info">
  {{ session('info') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@endif

<div class="container">
  <div class="row">

    @foreach ($courses as $course)
    <div class="col-sm-3 my-3">
      <div class="card h-100">
        <img src="{{ $course->image_url ?: asset('images/ik_logo.jpg') }}" class="card-img-top">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{$course["name"]}}</h5>
          <p class="card-text">{{Str::words($course["description"], $words = 10, $end = '...')}}</p>
          <p class="card-text">{{$course["code"]}}</p>
          <p class="card-text">{{$course["credit"]}}</p>
          <p class="card-text"><small class="text-muted">Last update: {{$course["updated_at"]}}</small></p>
          <div class="mt-auto">
            <a href="/courses/{{ $course['id'] }}" class="btn btn-primary btn-block my-1">Open</a>
            @can('update', $course)
            <a href="/courses/{{ $course['id'] }}/edit" class="btn btn-secondary btn-block my-1">Edit</a>
            @endcan
          </div>
        </div>
      </div>
    </div>
    @endforeach

  </div>
</div>
@endsection