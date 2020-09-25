<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class EvidenceController extends Controller
{
    public function evidence()
    {
       $user = DB::table('registor')->where('name', 'Olha')->first();
        echo $user->surname;
    }

}
