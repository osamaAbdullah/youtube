@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Video</div>
                    <div class="card-body">
                    @if($videos->count())
                        @foreach($videos as $video)
                            <div class="card card-block bg-light">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <img src="{{ url('images/' . $video->thumbnail . '/view') }}" alt="thumbnail" class="img-responsive">
                                    </div>
                                    <div class="col-sm-7">
                                        <a href="{{ url('videos/' . $video->uid . '/show') }}">{{$video->title}}</a>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="text-muted">
                                                    <span>{{ $video->created_at->toDateTimeString() }}</span>
                                                </p>
                                                <form action="{{ url('videos/' . $video->uid . '/delete') }}" method="post">
                                                    <button type="submit" class="btn btn-default">Delete</button>
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                                                </form>
                                                <a href="videos/{{$video->uid}}/edit" class="btn btn-info">Edit</a>
                                            </div>
                                            <div class="col-sm-6">
                                                <p>{{ ucfirst($video->visibility) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        @endforeach
                        {{ $videos->links() }}
                    @else
                        <p>You have no videos.</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection