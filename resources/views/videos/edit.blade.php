@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit video "{{ $video->title }}"</div>
                    <form action="{{ url('videos/' . $video->uid . '/update') }}" method="post">
                        {{method_field('PUT')}}
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" autofocus value="{{$video->title}}">
                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" autofocus>{{$video->description}}</textarea>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Visibility</label>
                            <select id="visibility" class="form-control{{ $errors->has('visibility') ? ' is-invalid' : '' }}" name="visibility" autofocus>
                                @foreach(['public','unlisted','private'] as $visibility)
                                    <option value="{{$visibility}}" {{ $video->visibility === $visibility ? 'selected' : '' }} >{{ ucfirst($visibility) }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('visibility'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('visibility') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>
                            <input type="checkbox" name="allow_votes" {{ $video->votesAllowed() ? 'checked' : '' }}> Allow votes
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                            <input type="checkbox" name="allow_comments" {{ $video->commentsAllowed() ? 'checked' : '' }}> Allow comments
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Update</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection