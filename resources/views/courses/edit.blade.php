@extends('layouts.main')

@section('title', 'Edit course page')

@section('content')
<div class="container py-3">
  <h2>Edit a course</h2>
  <form action="/courses/{{ $course['id'] }}" method="post">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="name">Course name</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="" value="{{ old('name', $course['name']) }}">
      @error('name')
      <div class="invalid-feedback">
        Please choose a name for the course.
      </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $course['description']) }}</textarea>
      @error('description')
      <div class="invalid-feedback">
        Please choose a description for the course.
      </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="code">Course code</label>
      <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" placeholder="IK-SSSNNN" value="{{ old('code', $course['code']) }}">
      @error('code')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="credit">Credit value</label>
      <input type="text" class="form-control @error('credit') is-invalid @enderror" name="credit" placeholder="" value="{{ old('credit',$course['credit']) }}">
      @error('credit')
      <div class="invalid-feedback">
        Please choose valid credit points.
      </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="image_url">Background image URL</label>
      <input type="text" class="form-control @error('image_url') is-invalid @enderror" name="image_url" placeholder="" value="{{ old('image_url', $course['image_url']) }}">
      @error('image_url')
      <div class="invalid-feedback">
        Please choose a valid url.
      </div>
      @enderror
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Finish</button>
    </div>

  </form>
</div>
@endsection