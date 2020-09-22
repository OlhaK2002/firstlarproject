<?php

namespace App\Http\Controllers;
use App\Http\Models\CommentModel;
use App\Http\Models\HomeModel;
use Illuminate\Http\Request;



class CommentController extends Controller
{
    protected $model;

    public function commentAction()
    {
        $this->model = new CommentModel();
        $array = $this->model->indexAction();
        //var_dump($array);
        return view('reply', compact('array'));
    }
}
