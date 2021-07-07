@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Channel settings</div>
                    <div class="card-body">
                        <form action="{{url('/channels/' .  $channel->slug . '/update')}}" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Name</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $channel->name }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Slug</label>
                                    <div class="input-group">
                                        <div class="input-group-text">http://localhost</div>
                                        <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ $channel->slug }}" required autofocus>
                                    </div>
                                    @if ($errors->has('slug'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" autofocus>{{$channel->description}}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Image</label>
                                        <input id="image" type="file" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" value="{{ $channel->image }}" autofocus>
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Update</button>
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <input type="hidden"name="id"value="{{$channel->id}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection