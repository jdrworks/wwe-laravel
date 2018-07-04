@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h1>Videos</h1><a href="{{ route('video.create') }}" class="btn btn-success">Upload Video</a>
        </div>
        @foreach ($videos as $video)
            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">{{ $video->title }}</span>
                    </div>
                    <div class="panel-body">
                        <video width="512" height="288" controls class="embed-responsive embed-responsive-16by9">
                            <source src="/app/{{ $video->file }}" type="video/mp4" class="embed-responsive-item">
                        </video> 
                        <a class="btn btn-primary" href="{{ route('video', ['id' => $video->id]) }}">See More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection