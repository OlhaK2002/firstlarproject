<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{

    public function rules()
    {
        return [
            'Email' => ['unique:registor'],
            'Login' => ['unique:registor'],
            'Password1' => ['min:6', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}$/'],
            'Password2' => ['same:Password1']
        ];
    }

    public function messages()
    {
        return [
            'Email.unique' => 'Ваша почта уже используется другим пользователем',
            'Login.unique' => 'Ваш логин уже используется другим пользователем',
            'Password1.min' => 'Пароль должен быть не меньше шести символов',
            'Password1.regex' => 'Пароль должен содержать цифры, а также символы верхнего и нижнего регистра',
            'Password2.same' => 'Пароли не совпадают'
        ];
    }
}
