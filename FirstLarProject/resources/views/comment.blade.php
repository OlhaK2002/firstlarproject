@extends('layouts.app')
@section('content')
    <title-component></title-component>

    <div class="content text">
        <field-component :bool="@json(Auth::check())"></field-component>

        @foreach ($array as $key => $value)
            <comment-component :value='@json($value)' ></comment-component>

            <div class="accordion" id="accordionExample">
                <reply-component :value='@json($value)' :bool='@json(Auth::check())'></reply-component>
        @endforeach
@endsection
