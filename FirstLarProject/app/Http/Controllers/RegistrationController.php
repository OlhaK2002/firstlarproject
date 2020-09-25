<?php

namespace App\Http\Controllers;

use App\Http\Models\RegistrationModel;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    protected $model;

    public function view()
    {
        return view('registration');
    }

    public function register()
    {
        $this->model = new RegistrationModel();
        $this->model->register($_POST['Name'], $_POST['Surname'], $_POST['Email'], $_POST['Login'], $_POST['Password1'], $_POST['Password2']);
        $this->model->email_evidence();
        $this->model->login_evidence();
        $this->model->passwords_evidence();
        $this->model->password_evidence();
        $this->model->password1_evidence();
        $this->model->hash();
        $array = $this->model->result();
        $result1 = json_encode($array);
        echo $result1;
    }

}
