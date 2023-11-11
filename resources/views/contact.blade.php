@extends('layouts.main')

@section('title', 'Contact')

@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">
                    Contact Information
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Student Name:</strong> Yousef Al-Akhali</li>
                        <li class="list-group-item"><strong>Neptun Code:</strong> AYTPDH</li>
                        <li class="list-group-item"><strong>Email:</strong> <a href="mailto:aytpdh@inf.elte.hu" class="email-link">aytpdh@inf.elte.hu</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<style>
    a.email-link {
        color: blue;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
    }

    .card-body {
        border-top: 1px solid #dee2e6;
    }

    .list-group-item:first-child {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .list-group-item:last-child {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
</style>
@endsection