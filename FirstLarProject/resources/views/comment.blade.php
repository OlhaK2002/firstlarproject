@extends('layouts.app')
@section('content')
    <title-component></title-component>
    <div class = "accordion" id = "accordionExample">
    <comment-component :array = '@json($array)' :bool = '@json(Auth::check())'></comment-component>
@endsection

