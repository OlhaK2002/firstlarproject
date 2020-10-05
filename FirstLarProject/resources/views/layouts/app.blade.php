<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
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
        </style>
    </head>
    <body>
        <div id="app">
            <menu-component :bool='@json(Auth::check())' :users='@json(Auth::user())'></menu-component>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>

