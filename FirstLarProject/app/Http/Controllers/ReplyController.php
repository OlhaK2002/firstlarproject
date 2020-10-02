<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    public function reply()
    {
        $model= new Comment();
        $model->reply('1', 0, Auth::id(), 0);
        $array = $model->result();
        if (!empty($array)) {
            return response()->json($array, Response::HTTP_OK);
        }
    }
}
