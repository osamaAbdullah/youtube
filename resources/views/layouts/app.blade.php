<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.youtube = {
            url: '{{ config('app.url') }}',
            id: {{ Auth::check() ? Auth::user()->id : null }},
            authenticated: {{ Auth::check() ? true : false }},
        }
    </script>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ url('images/' . 'logo.png' . '/view') }}" type="image/gif" sizes="20x20">
	
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        @yield('styles')
    </style>
</head>
<body>
    <div id="app">
        @include('layouts.partials._navigation')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
@yield('scripts')
</html>
