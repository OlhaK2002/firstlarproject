<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $fillable = ['user_id', 'text', 'parent_id', 'nesting', 'number_in_parent'];
    protected $array_view;
    protected $index = 0;
    protected $text1;
    protected $user_id1;
    protected $parent_id1;
    protected $nesting1;
    protected $number_in_parent1;
    protected $children_count;
    protected $number;


    public function users()
    {
        return $this::belongsTo('App\User',  'user_id','id' );
    }

    public function firstComment($id, $from, $to)
    {
        $comments = $this::where('parent_id', $id)->get();
        foreach ($comments as $comment) {
            $count = 0;
            $this->index++;
            $id = $comment->id;
            $text = $comment->text;
            $parent_id = $comment->parent_id;
            $nesting = $comment->nesting;
            $number_in_parent = $comment->number_in_parent;
            $data = date($comment->updated_at);
            if ($number_in_parent >= $from && $number_in_parent <= $to && $count<=($to-$from)) {
                $count++;
                $this->otherComments($id, $text, $data, $parent_id, $nesting, $number_in_parent);
            }
        }
        return $this->array_view;
    }

    public function otherComments($id, $text, $data, $parent_id, $nesting, $number_in_parent)
    {
        $user = $this::find($id);
        $count_children = $this::where('parent_id', $id)->count();

        $nesting = $nesting + 1;
        $this->array_view[] = [
            'id' => $id,
            'author' => $user->users['name'],
            'text' => $text,
            'parent_id' => $parent_id,
            'nesting' => $nesting,
            'data' => $data,
            'number_in_parent' => $number_in_parent,
            'count_children' => $count_children,
        ];
    }

    public function countComment(){
        $count_children0 = $this::where('parent_id', 0)->count();
        return $count_children0;
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
        $number_in_parent1 = $this::where('parent_id', $this->parent_id1)->count();
        $this->number_in_parent1 = $number_in_parent1 + 1;

        $this::create([
            'text' => $this->text1,
            'parent_id' => $this->parent_id1,
            'user_id' => $this->user_id1,
            'nesting' => $this->nesting1,
            'number_in_parent' => $this->number_in_parent1,
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
                ['nesting', $this->nesting1],
            ])->first();

            $id = $comment->id;
            $text = $comment->text;
            $parent_id = $comment->parent_id;
            $nesting = $comment->nesting;
            $number_in_parent = $comment->number_in_parent;
            $data = date($comment->updated_at);

            $user = $this::find($id);

            $this->nesting1 = $nesting + 1;
            $array_view2 = [
                'id' => $id,
                'author' => $user->users['name'],
                'text' => $text,
                'parent_id' => $parent_id,
                'nesting' => $this->nesting1,
                'data' => $data,
                'number_in_parent' => $number_in_parent,
                'count_children' => 0,
            ];
            return $array_view2;
        }
    }

}
