<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $fillable = ['user_id', 'text', 'parent_id', 'nesting'];

    public function users()
    {
        return $this->belongsTo('App\User',  'user_id','id' );
    }
}

