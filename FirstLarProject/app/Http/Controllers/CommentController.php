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
        //dd($array);
        //return view('welcome', compact('array'));
        return view('comment', compact('array'));
    }
}
