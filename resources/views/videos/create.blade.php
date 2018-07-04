@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h1>Upload Video</h1>
            <hr>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{url('video/create')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-xs-12">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <input type="file" name="video">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Create">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection