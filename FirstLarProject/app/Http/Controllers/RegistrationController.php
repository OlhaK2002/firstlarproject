<?php

namespace App\Http\Controllers;

use App\Http\Models\RegistrationModel;
use App\Http\Requests\StoreArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    protected $model;

    public function view()
    {
        return view('registration');
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Email' => ['unique:registor'],
            'Login' => ['unique:registor'],
            'Password1' => ['min:6'],
            'Password2' => ['same:Password1']
        ]);


        if (!($validator->passes())) {


            return response()->json(['error'=>$validator->errors()->all()]);
        }


        $this->model = new RegistrationModel();
        $this->model->register($_POST['Name'], $_POST['Surname'], $_POST['Email'], $_POST['Login'], $_POST['Password1'], $_POST['Password2']);
        $this->model->password1_evidence();
        $this->model->hash();
        $array = $this->model->result();
        $result1 = json_encode($array);
        echo $result1;
    }

}
