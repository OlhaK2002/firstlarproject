@extends('layouts.app')
@section('content')
    <home-component :bool="@json(session('status'))"></home-component>
@endsection
