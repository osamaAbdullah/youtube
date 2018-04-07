@extends('layouts.app')
@section('styles')
    .video-placeholder {
    position: relative;
    background-color: #111;
    padding-top: 56.25%;
    width: 100%;
    max-width: 100%;
    }
    .video-placeholder__header {
    font-size: 14px;
    position: absolute;
    top: 50%;
    transform: translateX(-50%);
    left: 50%;
    }
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()) )
                    <div class="alert alert-info">
                        your video is currently private. only you can see it.
                    </div>
                    <video-player video-uid="{{ $video->uid }}" video-url="{{ url('videos/' . $video->video_filename . '/view') }}" thumbnail-url="{{ url('images/' . 'default.png' . '/view') }}"></video-player>
                @elseif( $video->isProcessed() && $video->canBeAccessed(Auth::user()) )
                    <video-player video-uid="{{ $video->uid }}" video-url="{{ url('videos/' . $video->video_filename . '/view') }}" thumbnail-url="{{ url('images/' . 'default.png' . '/view') }}"></video-player>
                @else
                        <div class="video-placeholder">
                            <div class="video-placeholder__header">
                                this video is private
                            </div>
                        </div>
                @endif

                <div class="card">
                    <div class="card-body">
                       <h4>{{ $video->title }}</h4>
                        <div class="float-right">


                            video views


                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="{{url('channels/' . $video->channel->slug )}}">
                                    <img src="{{ url('images/' . $video->channel->image . '/view') }}" alt="{{ $video->channel->name }} image">
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="{{url('channels/' . $video->channel->slug .'/show')}}" class="media-heading">{{ $video->channel->name }}</a>
                                subscribe
                            </div>
                        </div>
                    </div>
                </div>
                @if($video->description)
                    <div class="card">
                        <div class="card-body">
                           {!! nl2br(e($video->description)) !!}
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        @if($video->commentsAllowed())
                            comments
                        @else
                            <p>comments are disabled for this video</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection