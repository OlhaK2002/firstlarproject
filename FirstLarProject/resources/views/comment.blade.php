@extends('layouts.app')
@section('content')
    <title-component></title-component>
    <div class="content text">

        @if(Auth::check())
            <field-component></field-component>
        @else
            <h4>  Для того чтобы оставить свой отзыв - <a style = "color: lightcoral" href="{{route('login')}}">войдите</a> или <a style = "color: lightcoral" href="{{route('register')}}">зарегистрируйтеся</a></h4><br><br>
        @endif
        @foreach ($array as $key => $value)
            <comment-component :value='@json($value)' ></comment-component>
        @endforeach
@endsection
