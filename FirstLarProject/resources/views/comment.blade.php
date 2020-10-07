@extends('layouts.app')
@section('content')
    <title-component></title-component>
    <div class = "accordion" id = "accordionExample">
    <comment-component :array = '@json($array)' :bool = '@json(Auth::check())' :array_limit = '@json($array_limit)'></comment-component>
@endsection

