<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class CommentModel extends Model
{
    protected $db;
    protected $sql;
    protected $result;
    protected $value0;
    protected $array;
    protected $index;
    protected $pdo;
    protected $array_view;
    protected $ind = 0;
    protected $nesting = 0;

    public function firstcomment()
    {
        $comments = Comment::where('parent_id', "0")->get();

        foreach($comments as $comment){
            $this->ind++;
            $id = $comment->id;
            $user_id = $comment->user_id;
            $text = $comment->text;
            $parent_id = $comment->parent_id;
            $nesting = $comment->nesting;
            $data = $comment->data;
            $this->othercomments($id, $user_id, $text, $data, $parent_id, $nesting);
        }

        return $this->array_view;
    }

    public function othercomments($id, $user_id, $text, $data, $parent_id, $nesting)
    {
        $user= Comment::find($id);

        $this->nesting = $nesting + 1;
        $this->array_view[$this->ind] = [
            'id' => $id,
            'author' => $user->users['name'],
            'text' => $text,
            'parent_id' => $parent_id,
            'nesting' => $this->nesting,
            'data' => $data,
        ];

        $comments = Comment::where('parent_id', $id)->get();

        if (!(empty($comments))) {
            foreach($comments as $comment){
                $this->ind++;
                $id = $comment->id;
                $user_id = $comment->user_id;
                $text = $comment->text;
                $parent_id = $comment->parent_id;
                $nesting = $comment->nesting;
                $data = $comment->data;
                $this->othercomments($id, $user_id, $text, $data, $parent_id, $nesting);
            }
        }
    }
}
