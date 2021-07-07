@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()) )
                    <div class="alert alert-info">
                        your video is currently private. only you can see it.
                    </div>
                    <video-player uid="{{ $video->uid }}" video-url="{{ url('videos/' . $video->video_filename . '/view') }}" thumbnail-url="{{ url('images/' . 'defaultThumbnail.png' . '/view') }}"></video-player>
                @elseif( $video->isProcessed() && $video->canBeAccessed(Auth::user()) )
                    <video-player uid="{{ $video->uid }}" video-url="{{ url('videos/' . $video->video_filename . '/view') }}" thumbnail-url="{{ url('images/' . 'defaultThumbnail.png' . '/view') }}"></video-player>
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
                            <div class="video__views">
                                {{ $video->viewCount() . ' ' . str_plural('view', $video->viewCount()) }}
                            </div>
                            @if($video->votesAllowed())
                                <video-voting video-uid="{{ $video->uid }}"></video-voting>
                            @else
                                <p>voting is not allowed on this video</p>
                            @endif
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="{{url('channels/' . $video->channel->slug )}}">
                                    <img src="{{ url('images/' . $video->channel->image . '/view') }}" alt="{{ $video->channel->name }} image">
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="{{ url('channels/' . $video->channel->slug .'/show') }}" class="media-heading">{{ $video->channel->name }}</a>
                                <subscribe-button channel-slug="{{ $video->channel->slug }}"></subscribe-button>
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
                            <video-comments get-comments-url="{{ url('videos/' . $video->uid . '/comments') }}" uid="{{ $video->uid }}"></video-comments>
                        @else
                            <p>comments are disabled for this video</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection