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
            $data = $comment->data;
            $parent_id = $comment->parent_id;
            $nesting = $comment->nesting;
            $this->othercomments($id, $user_id, $text, $data, $parent_id, $nesting);
        }

        return $this->array_view;
    }

    public function othercomments($id, $user_id, $text, $data, $parent_id, $nesting)
    {
       //$array = User::find($user_id)->comments()->where('comment.id', '=', $this->index)->first();
        $array2= Comment::find($id);



            $this->nesting = $nesting + 1;
            $this->array_view[$this->ind] = [
                'nesting' => $this->nesting,
                'author' => $array2->users['name'],
                'data' => $data,
                'text' => $text,
                'id' => $id,
                'parent_id' => $parent_id
            ];

        $comments = Comment::where('parent_id', $id)->get();

        if (!(empty($comments))) {
            foreach($comments as $comment){
                $this->ind++;
                $id = $comment->id;
                $user_id = $comment->user_id;
                $text = $comment->text;
                $data = $comment->data;
                $parent_id = $comment->parent_id;
                $nesting = $comment->nesting;
                $this->othercomments($id, $user_id, $text, $data, $parent_id, $nesting);
            }
        }
    }
}
