<?php

namespace App\Http\Controllers;
use App\Http\Models\AuthorizationModel;

use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public $model;
    public $login;
    public $password;

    public function viewAction()
    {
        return view('authorizationview');
    }
    public function loginAction()
    {
        $this->model = new AuthorizationModel();
        $this->model->login("{$_POST['login1']}", "{$_POST['password2']}");
        $array = $this->model->result();
        $result = json_encode($array);
        echo $result;


    }

}
