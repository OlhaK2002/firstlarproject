<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Comment();
    }

    public function commentView()
    {
        $array = $this->model->firstComment(0, 1, 3);
        $count_comment0 = $this->model->countComment();
        $array_limit = [
            'perPage' => config('app.comments'),
            'children_limit' => config('app.max_children_comments'),
            'count_comment0' => $count_comment0,
        ];
        return view('comment', compact('array'), compact('array_limit'));
    }

    public function comment()
    {
        $array = $this->model->firstComment($_POST['id'], $_POST['from'], $_POST['to']);
            return response()->json($array, Response::HTTP_OK);

    }

    public function reply()
    {
        $this->model->reply($_POST['text'], $_POST['parent_id'], Auth::id(), $_POST['nesting']);
        $array = $this->model->result();
        if (!empty($array) && 'text' != "") {
            return response()->json($array, Response::HTTP_OK);
        }
    }

}
