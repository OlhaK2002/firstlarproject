<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuthorizationModel extends Model
{
    protected $login;
    protected $password;
    protected $sql;
    protected $array;
    protected $hash;
    protected $password_verification;
    protected $user_id;
    protected $error = [];

    public function login($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function evidence()
    {
        $users = DB::table('registor')->where('login', "{$this->login}")->first();
        $this->hash = $users->password1;
        $this->user_id = $users->user_id;

        $this->password_verification = password_verify($this->password, $this->hash);
        return $this->password_verification;
    }

    public function result()
    {
        $this->error['error_login'] = "Неверный логин или пароль";
        if (strlen($this->password) > 0 && $this->evidence()) {
            session(['login'=> "{$this->login}"]);
            session(['user_id' => "{$this->user_id}"]);
            $this->error['error_login'] = "";

        }
        return $this->error;
    }
}
