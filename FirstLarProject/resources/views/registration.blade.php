@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>
                    <div class="card-body">
                        <form>
                            {{ csrf_field() }}
                            <span>Имя: </span><br/>
                            <input id="Name" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required type="text" name="Name"/>
                            <br/><br/><span>Фамилия: </span><br/>
                            <input id="Surname" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required type="text" name="Surname"/>
                            <br/><br/><span>Почта: </span><br/>
                            <input id="Email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required type="email" name="Email"/>
                            <div id="error_email" style="color: red"></div>
                            <br/><br/><span>Логин: </span><br/>
                            <input id="Login" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required type="text" name="Login" />
                            <div id="error_login" style="color: red"></div>
                            <br/><br/><span>Пароль: </span><br/>
                            <input id="Password1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required type="password" name="Password1" />
                            <div id="error_password" style="color: red"></div>
                            <div id="error_password1" style="color: red"></div>
                            <br/><br/><span>Подтверждение пароля:</span><br/>
                            <input id="Password2" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required type="password" name="Password2" />
                            <div id="error_passwords" style="color: red"></div>
                            <br/><br/><button id="registration" type="submit" name="Button_s" class="btn btn-light" >Зарегистрироваться</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

