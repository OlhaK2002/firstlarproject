<?php

namespace App\Http\Controllers;

use App\Http\Models\CommentModel;
use App\Http\Models\HomeModel;
use Illuminate\Http\Request;


class LogoutController extends Controller
{
    public function logoutAction()
    {
        session(['login' => ""]);
        session(['user_id' => ""]);
        return redirect('/');
    }
}
