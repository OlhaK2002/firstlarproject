<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Routevalue extends Controller
{
    public function wewee()
    {
        $route = Route::current();
        echo $route;
    }
}
