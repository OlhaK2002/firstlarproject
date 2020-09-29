<?php

namespace App\Http\Controllers;

use App\CommentModel;

class CommentController extends Controller
{
    protected $model;

    public function comment()
    {
        $this->model = new CommentModel();

        $array = $this->model->firstcomment();
        return view('comment', compact('array'));
    }
}
