<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

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

    public function email_evidence()
    {
        $users = DB::select('select * from `registor` where `email`=:email', ['email'=>$this->email]);
        if(!(empty($users))){$this->error['error_email'] = "Ваша почта уже используется другим пользователем";}

    }

    public function login_evidence()
    {
        $users = DB::select('select * from `registor` where `login`= :login', ['login'=>$this->login]);
        if(!(empty($users))){$this->error['error_login'] = "Ваш логин уже используется другим пользователем";}
    }

    public function passwords_evidence()
    {
        if($this->password1!=$this->password2){$this->error['error_passwords'] = "Пароли не совпадают";}

    }

    public function password_evidence()
    {
        if(strlen($this->password1)>0&&strlen($this->password1)<6) {$this->error['error_password'] = "Пароль должен быть не меньше шести символов";}

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
            $users = DB::insert('insert into `registor` (`name`,`surname`,`email`,`login`,`password1`) values (:name, :surname, :email, :login, :password1)', ['name'=>$this->name, 'surname'=> $this->surname, 'email'=>$this->email, 'login'=>$this->login, 'password1'=>$this->password]);
            return true;
        }
        else return false;
    }

    public function result()
    {
        if($this->into_db())
        {
            $array = DB::select('select * from `registor` where `name`= :name and `surname`=:surname and `email`=:email and `login`=:login and `password1`=:password1', ['name'=>$this->name, 'surname'=> $this->surname, 'email'=>$this->email, 'login'=>$this->login, 'password1'=>$this->password]);
            foreach ($array as $user) {
                $this->user_id = $user->user_id;
            }
            session(['login'=> "{$this->login}"]);
            session(['user_id' => "{$this->user_id}"]);
            $this->error['success'] = "success";
        }
        return $this->error;
    }

}
