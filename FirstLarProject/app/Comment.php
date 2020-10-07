<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $fillable = ['user_id', 'text', 'parent_id', 'nesting'];
    protected $array_view;
    protected $index = 0;
    protected $text1;
    protected $user_id1;
    protected $parent_id1;
    protected $nesting1;
    protected $children_count;
    protected $number;


    public function users()
    {
        return $this::belongsTo('App\User',  'user_id','id' );
    }

    public function firstComment()
    {
        $comments = $this::where('parent_id', "0")->get();
        $count = 0;
        foreach ($comments as $comment) {
            $this->index++;
            $id = $comment->id;
            $text = $comment->text;
            $parent_id = $comment->parent_id;
            $nesting = $comment->nesting;
            $data = date($comment->updated_at);
            $count++;
            $this->otherComments($id, $text, $data, $parent_id, $nesting, $count);
        }
        return $this->array_view;
    }

    public function otherComments($id, $text, $data, $parent_id, $nesting, $count)
    {
        $user= $this::find($id);
        $count_children = $this::where('parent_id', $id)->count();

        $nesting = $nesting + 1;
        $this->array_view[] = [
            'id' => $id,
            'author' => $user->users['name'],
            'text' => $text,
            'parent_id' => $parent_id,
            'nesting' => $nesting,
            'data' => $data,
            'page' => 0,
            'number_in_parent' => $count,
            'count_children' => $count_children,
        ];

        $comments = $this::where('parent_id', $id)->get();

        $count2 = 0;
        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $this->index++;
                $id = $comment->id;
                $text = $comment->text;
                $parent_id = $comment->parent_id;
                $nesting = $comment->nesting;
                $data = date($comment->updated_at);
                $count2++;
                $this->otherComments($id, $text, $data, $parent_id, $nesting, $count2);
            }
        }
    }

    public function reply($text, $parent_id, $user_id, $nesting)
    {
        $this->text1 = $text;
        $this->parent_id1 = $parent_id;
        $this->user_id1 = $user_id;
        $this->nesting1 = $nesting;
    }

    public function into()
    {
        $this::create([
            'text' => $this->text1,
            'parent_id' => $this->parent_id1,
            'user_id' => $this->user_id1,
            'nesting' => $this->nesting1
        ]);
        return true;
    }

    public function result()
    {
        if ($this->text1 != "" && $this->user_id1 != "" && $this->into()) {

            $comment = $this::where([
                ['text', $this->text1],
                ['parent_id', $this->parent_id1],
                ['user_id', $this->user_id1],
                ['nesting', $this->nesting1]
            ])->first();

            $id = $comment->id;
            $text = $comment->text;
            $parent_id = $comment->parent_id;
            $nesting = $comment->nesting;
            $data = date($comment->updated_at);

            $user = $this::find($id);
            $array = $this->array_view;

            $this->nesting1 = $nesting + 1;
            $array_view2 = [
                'id' => $id,
                'author' => $user->users['name'],
                'text' => $text,
                'parent_id' => $parent_id,
                'nesting' => $this->nesting1,
                'data' => $data,
                'page' => 0,
                'count_children' => 0,
            ];
            return $array_view2;
        }
    }

}
