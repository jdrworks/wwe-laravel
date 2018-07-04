@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h1>{{ $video->title }}</h1>
            <video width="512" height="288" controls class="embed-responsive embed-responsive-16by9">
                <source src="/app/{{ $video->file }}" type="video/mp4" class="embed-responsive-item">
            </video> 
        </div>
    </div>
@endsection