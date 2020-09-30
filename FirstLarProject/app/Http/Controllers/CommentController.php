<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Comment();
    }

    public function comment()
    {
        $array = $this->model->firstComment();
        return view('comment', compact('array'));
    }

    public function reply()
    {
        $this->model->reply($_POST['text'], $_POST['parent_id'], Auth::id(), $_POST['nesting']);

        $array = $this->model->result();
        if (!empty($array) && $_POST['text'] != "") {
            return view('reply', compact('array'));
        }
    }

}
