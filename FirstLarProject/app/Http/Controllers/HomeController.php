<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\HomeModel;

class HomeController extends Controller
{
    protected $model;

    public function index()
    {
         return view('home');
    }

}
