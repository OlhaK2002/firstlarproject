<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    public function users()
    {
        //return $this->belongsTo('App\User', 'id', 'user_id' );
        return $this->belongsTo('App\User',  'user_id','id' );
    }
}

