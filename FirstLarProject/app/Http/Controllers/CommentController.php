<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function comment()
    {
        $model = new Comment();
        $array = $model->firstComment();
        return view('comment', compact('array'));
    }
    public function reply()
    {
        $model = new Comment();
        $model->reply($_POST['text'], $_POST['parent_id'], Auth::id(), $_POST['nesting']);

        $array = $model->result();
        if (!empty($array) && $_POST['text'] != "") {
            return view('reply', compact('array'));
        }
    }

}
