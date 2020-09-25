<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class ReplyModel extends Model
{
    protected $text;
    protected $parent_id;
    protected $authorid;
    protected $nesting;
    protected $pdo;
    protected $count;
    protected $sql;
    protected $array;
    protected $array1;
    protected $array_view;
    protected $index;
    protected $id;

    public function reply( $text, $parent_id, $author_id, $nesting)
    {
        $this->text = $text;
        $this->parent_id = $parent_id;
        $this->authorid = $author_id;
        $this->nesting = $nesting;
    }

    public function into()
    {
        if($this->text!=""&&$this->authorid!=""&&$this->count<1)
        {
            $users = DB::insert('insert into `comments` (`authorid`,`text`, `parent_id`, `nesting`) values (:authorid, :text, :parent_id, :nesting)',['authorid'=>$this->authorid, 'text'=> $this->text, 'parent_id'=>$this->parent_id, 'nesting'=>$this->nesting]);
            $this->count++;
        }
        return true;
    }


    public function result()
    {
        if($this->text!=""&&$this->authorid!="" && $this->into()){

            $comments = DB::select('select * from `comments`  where `text`=:text and `parent_id`=:parent_id and `authorid`=:authorid and `nesting`=:nesting', ['text'=> "{$this->text}", 'parent_id'=> "{$this->parent_id}", 'authorid'=> "{$this->authorid}", 'nesting'=> "{$this->nesting}"]);

            foreach($comments as $comment)
            {
                $this->id = $comment->id;
            }

            $comments = DB::select('select * from `registor`  inner join `comments` where registor.user_id=comments.authorid AND comments.id=:id', ['id'=> "{$this->id}"]);

            foreach($comments as $array){
                $this->nesting = $array->nesting + 1;
                $this->array_view = [
                    'nesting' => "{$this->nesting}",
                    'author' => "{$array->login}",
                    'data' => "{$array->data}",
                    'text' => "{$array->text}",
                    'id' => "{$array->id}",
                    'parent_id' => "{$array->parent_id}"
                ];
            }

            return $this->array_view;
        }

    }
}
