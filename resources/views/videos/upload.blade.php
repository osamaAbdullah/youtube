@extends('layouts.app')

@section('content')
    <video-upload store-in-database-url="{{ url('video/store') }}" upload-to-server-url="{{ url('video/upload') }}" update-url="{{ url('videos/%uid%/update') }}"></video-upload>
@endsection
