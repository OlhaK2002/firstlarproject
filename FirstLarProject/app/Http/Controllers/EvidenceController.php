<?php

namespace App\Http\Controllers;
use App\Http\Models\AuthorizationModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvidenceController extends Controller
{
    protected $login;
    protected $password;
    protected $sql;
    protected $array;
    protected $hash;
    protected $password_verification;
    protected $user_id;
    protected $error = [];

    public function evidence()
    {
        $this->login = "Olha019";
        $users = DB::select('select * from `registor` where `login`=:login', ['login'=>$this->login]);
        foreach ($users as $user) {
            $this->hash = $user->password1;
            $this->user_id = $user->user_id;
        }
        echo $this->hash. ' '.$this->user_id;
    }

}

