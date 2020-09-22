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
        $this->login = $_POST['login1'];
        $this->password = $_POST['password2'];
        $this->model->loginAction($this->login, $this->password);
        if($this->model->passwordAction()){return redirect('/');}
        else {return redirect('/authorization/view');}


    }

}
