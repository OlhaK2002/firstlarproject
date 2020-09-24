<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

    <script src="{{ asset('js/jquery-3.5.1.js') }}" defer></script>
    <script src="{{ asset('js/authorization.js') }}" defer></script>
    <script src="{{ asset('js/registration.js') }}" defer></script>
    <script src="{{ asset('js/reply.js') }}" defer></script>
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 40vh;
        }

        .flex-center {
            margin: 0 0 0 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 20px;
        }


        .title {
            font-size: 140px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .text {
            font-size: 20px;
            padding: 0 15px;
        }
    </style>
</head>
<body>

<div class="flex-center position-ref full-height">

    <div class="top-right links">

        @php
       if(session('login') != "")
       {
       @endphp
        <a href="{{route("logout")}}">Logout</a>
        @php
       }
       else
       {
        @endphp
            <a href="{{route("authorizationview")}}">Login</a>
            <a href="{{route("registrationview")}}">Register</a>
        @php
       }
      @endphp

    </div>


    <div class="content">
        <hr>
        <div class="title m-b-md">
            Guest Book
        </div>
        <hr>
    </div>
</div>
<div class="content text">
    @if(session('login') != "")

     <form>
        {{ csrf_field() }}
        <textarea rows="3" required name="text" id="text_id0" class="form-control"
                  placeholder="Введите Ваш комментарий..."></textarea>
        <input type="hidden" id="parent_id0" class="parent" name="parent_id" value="0">
        <input type="hidden" id="nesting0" class="nesting" name="nesting" value="0">
        <button id="0" type="submit" class="btn">Отправить</button>
    </form><br><br>
    @endif

    @if(session('login') == "")
          <h4>  Для того чтобы оставить свой отзыв - <a style = "color: lightcoral" href="{{route("authorizationview")}}">войдите</a> или <a style = "color: lightcoral" href="{{route("registrationview")}}">зарегистрируйтеся</a></h4><br><br>
    @endif


        @yield('reply')
</div>


</body>
</html>
