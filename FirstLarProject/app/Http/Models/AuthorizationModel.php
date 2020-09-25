<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class AuthorizationModel extends Model
{
    protected $login;
    protected $password;
    protected $sql;
    protected $array;
    protected $hash;
    protected $password_verification;
    protected $error = [];

    public function login($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function evidence()
    {
        $pdo = DB::connection()->getPDO();
        $this->sql = $pdo->prepare("SELECT * FROM `registor` WHERE `login`= :login LIMIT 1");
        $this->sql->bindParam(':login', $this->login, PDO::PARAM_STR);
        $this->sql->execute();
        $this->array = $this->sql->FETCH(PDO::FETCH_ASSOC);
        $this->hash = $this->array['password1'];
        $this->password_verification = password_verify($this->password, $this->hash);
        return $this->password_verification;
    }

    public function result()
    {
        $this->error['error_login'] = "Неверный логин или пароль";
        if (strlen($this->password) > 0 && $this->evidence()) {
            session(['login'=> "{$this->login}"]);
            session(['user_id' => "{$this->array['user_id']}"]);
            $this->error['error_login'] = "";

        }
        return $this->error;
    }
}
