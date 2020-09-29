<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


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

    public function reply( $text, $parent_id, $user_id, $nesting)
    {
        $this->text = $text;
        $this->parent_id = $parent_id;
        $this->user_id = $user_id;
        $this->nesting = $nesting;
    }

    public function into()
    {
        if($this->text!=""&&$this->user_id!=""&&$this->count<1)
        {
            Comment::insert(['user_id' => $this->user_id, 'text' => $this->text, 'parent_id' => $this->parent_id, 'nesting' => $this->nesting]);
            $this->count++;
        }
        return true;
    }


    public function result()
    {
        if($this->text!=""&&$this->user_id!="" && $this->into()){

            $comments = Comment::where([
                ['text',  $this->text],
                ['parent_id',  $this->parent_id],
                ['user_id',  $this->user_id],
                ['nesting',  $this->nesting],
            ])->first();

            $this->id = $comments->id;

            $comments = User::join('comment', 'users.id', '=', 'comment.user_id')
                ->where('comment.id', '=', $this->id )
                ->get();

            foreach($comments as $array){
                $this->nesting = $array->nesting + 1;
                $this->array_view = [
                    'nesting' => $this->nesting,
                    'author' => $array->name,
                    'data' => $array->data,
                    'text' => $array->text,
                    'id' => $array->id,
                    'parent_id' => $array->parent_id
                ];
            }

            return $this->array_view;
        }

    }
}
