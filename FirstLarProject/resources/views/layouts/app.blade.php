<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        @if(Auth::check())
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="{{ asset('js/reply.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

        <style>
            html, body {
                background-color:#CFEDF1;
                color: #35848F;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .text {
                color: #35848F;
                font-size: 20px;
                padding: 0 15px;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <menu-component :bool="@json(Auth::check())" ></menu-component>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>

