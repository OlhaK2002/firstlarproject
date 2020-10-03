@extends('layouts.app')
@section('content')
    <title-component></title-component>
        <div class="accordion" id="accordionExample">
        <comment-component :array1='@json($array)' :bool='@json(Auth::check())'></comment-component>
@endsection

