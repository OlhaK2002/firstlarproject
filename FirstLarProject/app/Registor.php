<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registor extends Model
{
    protected $table = 'registor';

    public function authorization()
    {
        $user = App\Registor::where('login', $this->login)->first();
    }
}
