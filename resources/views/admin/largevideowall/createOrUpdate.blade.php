@extends('admin.layouts.master')
@section('title', isset($timeWall) ? 'Edit Large Video Wall' : 'Add Large Video Wall')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- ... (unchanged) ... -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($timeWall) ? 'Edit Large Video Wall' : 'Add Large Video Wall' }}</h3>
                        </div>
                        <form action="{{ isset($timeWall) ? route('admin.largevideowall.updateLargeVideoWall', $timeWall->id) : route('admin.largevideowall.storeLargeVideoWall') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($timeWall))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="video_name">Video Name</label>
                                    <input type="text" class="form-control @error('video_name') is-invalid @enderror" name="video_name" value="{{ isset($timeWall) ? $timeWall->video_name : old('video_name') }}" placeholder="Enter Video Name">
                                    @error('video_name')
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>                            
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="video_thumbnail">Video Thumbnail (Image)</label>
                                    <input type="file" class="form-control @error('video_thumbnail') is-invalid @enderror" name="video_thumbnail">
                                    @error('video_thumbnail')
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>                            
                                    @enderror
                                    @if(isset($timeWall) && $timeWall->video_thumbnail)
                                        <img src="{{ asset($timeWall->video_thumbnail) }}" alt="Thumbnail" style="max-width: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="video">Video File (MP4)</label>
                                    <input type="file" class="form-control @error('video') is-invalid @enderror" name="video">
                                    @error('video')
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>                            
                                    @enderror
                                    @if(isset($timeWall) && $timeWall->video_path)
                                        <video width="150" height="auto" controls>
                                            <source src="{{ asset($timeWall->video_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                                <!-- Add other form fields as needed -->
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ isset($timeWall) ? 'Update' : 'Add' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
