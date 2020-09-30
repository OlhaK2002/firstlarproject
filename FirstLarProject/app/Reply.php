<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
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
        Comment::create([
            'text' => $this->text,
            'parent_id' => $this->parent_id,
            'user_id' => $this->user_id,
            'nesting' => $this->nesting
        ]);
        return true;
    }

    public function result()
    {
        if ($this->text != "" && $this->user_id != "" && $this->into()) {

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
            $data = $comment->updated_at;

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
