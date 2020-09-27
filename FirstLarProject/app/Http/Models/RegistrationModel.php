<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Comment;
use App\Registor;


class RegistrationModel extends Model
{
    protected $name;
    protected $surname;
    protected $email;
    protected $login;
    protected $password1;
    protected $password2;
    protected $password;
    protected $count_0=0;
    protected $count_A=0;
    protected $count_b=0;
    protected $error = [];
    protected $array;
    protected $user_id;

    public function register($name, $surname, $email, $login, $password1, $password2)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->login = $login;
        $this->password1 = $password1;
        $this->password2 = $password2;
    }
 public function password1_evidence()
    {
        if (strlen($this->password1)>0){
            for($i=0;$i<strlen($this->password1);$i++) {
                if ($this->password1[$i] >= 'A' && $this->password1[$i] <= 'Z') $this->count_A++;
                if ($this->password1[$i] >= 'a' && $this->password1[$i] <= 'z') $this->count_b++;
                if ($this->password1[$i] >= '0' && $this->password1[$i] <= '9') $this->count_0++;
            }

            if(!($this->count_A>0 && $this->count_b>0 && $this->count_0 >0)) {
                $this->error['error_password1']="Пароль должен содержать цифры, а также символы верхнего и нижнего регистра";

            }

        }
    }

    public function hash()
    {
        $this->password = password_hash($this->password1, PASSWORD_DEFAULT);
        return $this->password;
    }
    public function into_db()
    {

        if(empty($this->error))
        {
            Registor::insert(['name' => $this->name, 'surname' => $this->surname, 'email' => $this->email, 'login' => $this->login, 'password1' => $this->password,]);
            return true;
        }
        else return false;
    }

    public function result()
    {
        if($this->into_db())
        {
            $users = Registor::where([
                ['name',  $this->name],
                ['surname',  $this->surname],
                ['email',  $this->email],
                ['login',  $this->login],
                ['password1',  $this->password],


            ])->first();

            $this->user_id = $users->user_id;

            session(['login'=> $this->login]);
            session(['user_id' => $this->user_id]);
            $this->error['success'] = "success";
        }
        return $this->error;
    }

}
