<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ReplyModel extends Model
{
    protected $text;
    protected $parent_id;
    protected $user_id;
    protected $nesting;
    protected $count = 0;
    protected $array_view;

    public function reply($text, $parent_id, $user_id, $nesting)
    {
        $this->text = $text;
        $this->parent_id = $parent_id;
        $this->user_id = $user_id;
        $this->nesting = $nesting;
    }

    public function into()
    {
        if($this->text != "" && $this->user_id != "" && $this->count < 1){
           /* $comment = Comment::create([
                'text' => $this->text,
                'parent_id' => $this->parent_id,
                'user_id' => $this->user_id,
                'nesting' => $this->nesting
            ]);*/
            $comment = new Comment();

            $comment->user_id = $this->user_id;
            $comment->text = $this->text;
            $comment->parent_id = $this->parent_id;
            $comment->nesting = $this->nesting;

            $comment->save();

            $this->count++;
        }
       return true;
    }

    public function result()
    {
        if($this->text != "" && $this->user_id != ""  &&  $this->into()){

            $comment = Comment::where([
                ['text', $this->text],
                ['parent_id', $this->parent_id],
                ['user_id', $this->user_id],
                ['nesting', $this->nesting]
            ])->first();

            $id = $comment->id;
            $text = $comment->text;
            $parent_id = $comment->parent_id;
            $nesting = $comment->nesting;
            $data = $comment->data;

            $user = Comment::find($id);

            $this->nesting = $nesting + 1;
            $this->array_view = [
                'id' => $id,
                'author' => $user->users['name'],
                'text' => $text,
                'parent_id' => $parent_id,
                'nesting' => $this->nesting,
                'data' => $data,
           ];
           return $this->array_view;
        }
    }
}
