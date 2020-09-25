<?php

namespace App\Http\Controllers;

use App\Http\Models\CommentModel;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $model;

    public function commentAction()
    {
        $this->model = new CommentModel();
        $array = $this->model->indexAction();
        return view('comment', compact('array'));
    }
}
