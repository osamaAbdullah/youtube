<div class="row">
    <div class="col-lg-5">
        <a href="{{ url('videos/' . $video->uid ) }}">
            <img src="{{ url('images/' . $video->thumbnail . '/view') }}" alt="{{ $video->title }} thumbnail" class="img-responsive">
        </a>
    </div>
    <div class="col-lg-7">
        <a href="{{ url('videos/' . $video->uid ) }}">{{ $video->title }}</a>
        @if($video->description)
            <p>{{ $video->description }}</p>
        @else
            <p>No description</p>
        @endif
        <ul class="list-inline">
            <li><a href="{{ url('channels/' . $video->channel->slug ) }}">{{ $video->channel->name }}</a></li>
            <li>{{ $video->created_at->diffForHumans() }}</li>
            <li>{{ $video->viewCount() . '' . str_plural('view', $video->viewCount()) }}</li>
        </ul>
    </div>
</div>