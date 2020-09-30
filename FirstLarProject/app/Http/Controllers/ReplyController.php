<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function reply()
    {
        $model = new Reply();
        $model->reply($_POST['text'], $_POST['parent_id'], Auth::id(), $_POST['nesting']);

        $array1 = $model->result();
        if (!empty($array1) && $_POST['text'] != "") {
            $array[0] = $array1;
            return view('reply', compact('array'));
        }
    }
}
