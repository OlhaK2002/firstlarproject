@extends('layouts.app')
@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <hr>
            <div class="title m-b-md">
                Guest Book
            </div>
            <hr>
        </div>
    </div>
    <div class="content text">
        @if(Auth::check())
            <form>
                {{ csrf_field() }}
                <textarea  style="background-color: #FFFAF7; border: #FFFAF7; margin-left: 20px;" rows="3" required name="text" id="text_id0" class="form-control nesting" placeholder="Введите Ваш комментарий..."></textarea>
                <input type="hidden" id="parent_id0" class="parent" name="parent_id" value="0">
                <input type="hidden" id="nesting0" class="nesting" name="nesting" value="0">
                <button style="background-color:#F2F2F2;margin-left: 20px;" id="0" type="submit" class="button1 btn btn-light">Отправить</button>
            </form><br><br>
        @else
            <h4>  Для того чтобы оставить свой отзыв - <a style = "color: lightcoral" href="{{route('login')}}">войдите</a> или <a style = "color: lightcoral" href="{{route('register')}}">зарегистрируйтеся</a></h4><br><br>
        @endif
        @foreach ($array as $key => $value)
            <div id="comment0"></div>
            <div style="margin-left:{{$value['nesting']*30}}px;" ><br>
                <div class="cool" style=" font-style: italic;">{{ $value['author'] }}</div>&nbsp
                <div class="cool" style="font-style: italic; color: #888988; ">({{$value["data"]}})</div><br>
                <div class="cool">{{$value['text']}}</div><br>
            </div>
            @if(Auth::check())
                <div class="accordion " id="accordionExample">
                    <div  class="card" style="background-color: white; border: white;margin-left: {{30*$value['nesting']}}px">
                        <div style="background-color: white; border: white; margin-left: {{30*$value['nesting']}}px" class="card-header" id="heading{{ $value['id'] }}">
                            <h2 class="mb-0">
                                <button style="color: #888988;margin-left: {{-30*$value['nesting']}}px" class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" aria-expanded="false" data-target="#collapse_{{ $value['id'] }}" aria-controls="collapse_{{ $value['id'] }}">
                                    Ответить
                                </button>
                            </h2>
                        </div>
                        <div id="collapse_{{ $value['id'] }}" class="collapse" aria-labelledby="heading{{ $value['id'] }}" data-parent="#accordionExample">
                            <div class="card-body">
                                <form>
                                    {{ csrf_field() }}
                                    <textarea  required name="text" id="text_id{{ $value['id'] }}" class="form-control"></textarea><br>
                                    <input type="hidden" id="parent_id{{ $value['id'] }}" class="parent_id" name="parent_id" value="{{ $value['id'] }}">
                                    <input type="hidden" id="nesting{{ $value['id'] }}" class="nesting" name="nesting" value="{{ $value['nesting'] }}">
                                    <button id="{{ $value['id'] }}" type="submit" class="button1 btn btn-light ">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="comment{{ $value['id'] }}"></div>
            @endif
        @endforeach
@endsection
