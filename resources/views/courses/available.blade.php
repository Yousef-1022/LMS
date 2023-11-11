@extends('layouts.main')

@section('title', 'Listing page')

@section('content')

<div class="container">
  <div class="row">

    @foreach ($courses as $course)
    <div class="col-sm-3 my-3">
      <div class="card h-100">
        <img src="{{ $course->image_url ?: asset('images/ik_logo.jpg') }}" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">{{$course["name"]}}</h5>
          <p class="card-text">{{Str::words($course["description"], $words = 10, $end = '...')}}</p>
          <p class="card-text">{{$course["code"]}}</p>
          <p class="card-text">{{$course["credit"]}}</p>
          <p class="card-text"><small class="text-muted">Last update: {{$course["updated_at"]}}</small></p>
        </div>
        <form action="{{ route('courses.available') }}?course_id={{ $course->id }}" method="POST">
          @csrf
          @method('POST')
          <button type="submit" class="btn btn-primary btn-success w-100">Enroll</button>
        </form>
      </div>
    </div>
    @endforeach

  </div>
</div>
@endsection