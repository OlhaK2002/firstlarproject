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
            DB::table('comments')->insert(['authorid' => $this->authorid, 'text' => $this->text, 'parent_id' => $this->parent_id, 'nesting' => $this->nesting]);
            $this->count++;
        }
        return true;
    }


    public function result()
    {
        if($this->text!=""&&$this->authorid!="" && $this->into()){

            $comments = DB::table('comments')->where([
                ['text',  $this->text],
                ['parent_id',  $this->parent_id],
                ['authorid',  $this->authorid],
                ['nesting',  $this->nesting],
            ])->first();

            $this->id = $comments->id;

            $comments = DB::table('registor')
                ->join('comments', 'registor.user_id', '=', 'comments.authorid')
                ->where('comments.id', '=', $this->id )
                ->get();

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
