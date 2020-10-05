<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'unique:users', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}$/'],
        ], [
            'name.unique' => 'Ваша почта уже используется другим пользователем',
            'email.unique' => 'Ваш логин уже используется другим пользователем',
            'password.min' => 'Пароль должен быть не меньше шести символов',
            'password.regex' => 'Пароль должен содержать цифры, а также символы верхнего и нижнего регистра',
            'password.confirmed' => 'Пароли не совпадают'
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
