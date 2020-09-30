<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $fillable = ['user_id', 'text', 'parent_id', 'nesting'];
    protected $array_view;
    protected $index = 0;

    public function users()
    {
        return $this::belongsTo('App\User',  'user_id','id' );
    }

    public function firstComment()
    {
        $comments = $this::where('parent_id', "0")->get();

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
        $user= $this::find($id);

        $nesting = $nesting + 1;
        $this->array_view[$this->index] = [
            'id' => $id,
            'author' => $user->users['name'],
            'text' => $text,
            'parent_id' => $parent_id,
            'nesting' => $nesting,
            'data' => $data,
        ];

        $comments = $this::where('parent_id', $id)->get();

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

    public function reply($text, $parent_id, $user_id, $nesting)
    {
        $this->text = $text;
        $this->parent_id = $parent_id;
        $this->user_id = $user_id;
        $this->nesting = $nesting;
    }

    public function into()
    {
        $this::create([
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

            $comment = $this::where([
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

            $user = $this::find($id);

            $this->nesting = $nesting + 1;
            $this->array_view[0] = [
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
