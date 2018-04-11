@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                       <div class="media">
                           <div class="media-left">
                               <img src="{{ url('images/' . $channel->image . '/view') }}" alt="{{ $channel->name }} image" class="media-object">
                           </div>
                           <div class="media-body">
                               {{ $channel->name }}
                               <ul class="list-inline">
                                   <li class="list-inline-item">
                                       <subscribe-button channel-url="{{ url('channels/' . $channel->slug .'/show') }}"></subscribe-button>
                                   </li>
                                   <li class="list-inline-item">
                                       {{ $channel->totalVideoViews() }} video {{ str_plural('View', $channel->totalVideoViews()) }}
                                   </li>
                               </ul>
                               @if($channel->description)
                                   <hr>
                                   <p>{{ $channel->description }}</p>
                               @endif
                           </div>
                       </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">Videos</div>
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                @if($videos->count())
                                    @foreach($videos as $video)
                                        @include('layouts.partials._video_result', [
                                        'video' => $video,
                                        ])
                                    @endforeach
                                    {{ $videos->links() }}
                                @else
                                    {{ $channel->name }} has no videos
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection