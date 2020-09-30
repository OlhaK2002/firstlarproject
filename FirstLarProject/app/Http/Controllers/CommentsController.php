<?php

namespace App\Http\Controllers;

use App\Comment;

class CommentsController extends Controller
{
    public function comment()
    {
        $model = new Comment();
        $array = $model->firstComment();
        return view('comment', compact('array'));
    }
}
