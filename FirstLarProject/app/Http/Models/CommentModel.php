<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class CommentModel extends Model
{
    protected $db;
    protected $sql;
    protected $result;
    protected $value0;
    protected $sql0;
    protected $array;
    protected $index;
    protected $pdo;
    protected $array_view;
    protected $ind = 0;
    protected $nesting = 0;

    public function firstcomment()
    {
        $comments = DB::select('select * from `comments` where `parent_id`=:parent_id', ['parent_id'=> 0]);

        foreach($comments as $comment){
            $this->ind++;
            $id = $comment->id;
            $this->othercomments($id);
        }

        return $this->array_view;
    }

    public function othercomments($id)
    {
        $this->index = $id;
        $comments = DB::select('select * from `registor` inner join `comments` where registor.user_id=comments.authorid and comments.id=:id', ['id'=> "{$this->index}"]);

        foreach($comments as $array){
            $this->nesting = $array->nesting + 1;
            $this->array_view["{$this->ind}"] = [
                'nesting' => "{$this->nesting}",
                'author' => "{$array->login}",
                'data' => "{$array->data}",
                'text' => "{$array->text}",
                'id' => "{$array->id}",
                'parent_id' => "{$array->parent_id}"
            ];
        }

        $comments = DB::select('select * from `comments` where `parent_id`=:parent_id', ['parent_id'=> $this->index]);

        if (!(empty($comments))) {
            foreach($comments as $comment){
                $this->ind++;
                $id = $comment->id;
                $this->othercomments($id);
            }
        }
    }
}
