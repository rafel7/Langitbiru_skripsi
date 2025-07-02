@extends('layouts.app')

@section('title', 'Video Pembelajaran 1')

@section('content')
<div class="w-100">
    <div class="d-flex justify-content-end mb-3">

        <a href=" {{ url('/pembelajaran/video2') }}" class="btn btn-primary" style="margin-right: 20px;">Next</a>
    </div>
    <h2 class="mb-4 text-center">Video Pembelajaran: 1</h2>

    <div class="video-container mb-4">
        <iframe src="https://www.youtube.com/embed/pbrpdUiSYMY"
            frameborder="0"
            allowfullscreen
            title="Video Pembelajaran"
            style="width: 100%; height: 60vh; border-radius: 8px;">
        </iframe>
    </div>



</div>
@endsection