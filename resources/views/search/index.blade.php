@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Results for "{{ Request::get('query') }}"</div>
                    @if($channels->count())
                        <h4>Channels</h4>
                        <div class="card card-block bg-light">
                            @foreach($channels as $channel)
                                <br>
                                <div class="media">
                                    <div class="media-left">
                                        <a href="{{ url('channel/' . $channel->slug) }}">
                                            <img src="{{ url('images/' . $channel->image . '/view') }}" alt="{{ $channel->name }} image" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a href="{{ url('channel/' . $channel->slug) }}" class="media-heading">{{ $channel->name }}</a>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">{{ $channel->subscriptionCount() . ' ' . str_plural($channel->subscriptionCount(), 'Subscriber') }} </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($videos->count())
                        <h4>Channels</h4>
                        @foreach($videos as $video)
                            @include('layouts.partials._video_result', [
                            'video' => $video
                            ]);
                        @endforeach
                    @else
                            <p>No videos found for "{{ Request::get('query') }}"</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection