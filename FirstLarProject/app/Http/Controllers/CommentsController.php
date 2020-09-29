<?php

namespace App\Http\Controllers;

use App\CommentsModel;

class CommentsController extends Controller
{
    public function comment()
    {
        $model = new CommentsModel();
        $array = $model->firstComment();
        return view('comment', compact('array'));
    }
}
