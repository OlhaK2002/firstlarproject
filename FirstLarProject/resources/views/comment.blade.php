@extends('layouts.app')
@section('content')
    <title-component></title-component>

    <field-component :bool="@json(Auth::check())"></field-component>

    <reply-component :array1='@json($array)' :bool='@json(Auth::check())'></reply-component>

 @php   /*@foreach ($array as $key => $value)
        <comment-component :value='@json($value)'></comment-component>
        <div class="accordion" id="accordionExample">
            <reply-component :value='@json($value)' :bool='@json(Auth::check())'></reply-component>
    @endforeach*/ @endphp
@endsection

