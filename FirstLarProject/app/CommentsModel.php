<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentsModel extends Model
{
    protected $array_view;
    protected $index = 0;

    public function firstComment()
    {
        $comments = Comment::where('parent_id', "0")->get();

        foreach ($comments as $comment) {
            $this->index++;
            $id = $comment->id;
            $text = $comment->text;
            $parent_id = $comment->parent_id;
            $nesting = $comment->nesting;
            $data = $comment->updated_at;
            $this->otherComments($id, $text, $data, $parent_id, $nesting);
        }

        return $this->array_view;
    }

    public function otherComments($id, $text, $data, $parent_id, $nesting)
    {
        $user= Comment::find($id);

        $nesting = $nesting + 1;
        $this->array_view[$this->index] = [
            'id' => $id,
            'author' => $user->users['name'],
            'text' => $text,
            'parent_id' => $parent_id,
            'nesting' => $nesting,
            'data' => $data,
        ];

        $comments = Comment::where('parent_id', $id)->get();

        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $this->index++;
                $id = $comment->id;
                $text = $comment->text;
                $parent_id = $comment->parent_id;
                $nesting = $comment->nesting;
                $data = $comment->updated_at;
                $this->otherComments($id, $text, $data, $parent_id, $nesting);
            }
        }
    }
}
