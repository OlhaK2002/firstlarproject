@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>
                    <div class="card-body">
                        <div class="field">
                        <form method = "POST" action = "{{ route('authorization') }}">
                            {{ csrf_field() }}
                            <span>Логин: </span><br/>
                            <input id="login1" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm" required type="text" name="login1"><br/><br/>
                            <span>Пароль: </span><br/>
                            <input id="password2" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm" required type="password" name="password2">
                            <div id="result" style="color: red"></div>
                            <br/><br/>
                            <button id="authorization" type="submit" class="btn btn-light">Войти</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

