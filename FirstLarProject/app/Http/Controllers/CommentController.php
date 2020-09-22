<?php

namespace App\Http\Controllers;
use App\Http\Models\CommentModel;
use Illuminate\Http\Request;



class CommentController extends Controller
{
    public function commentAction()
    {
        $model = new CommentModel();
        $model->commentAction("dkjwbwehkdbwekjdbwe");
        return view('comment');
    }
}
