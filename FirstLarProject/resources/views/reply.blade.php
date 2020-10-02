<div style="margin-left:{{$array['nesting']*30}}px;"><br>
    <div class="cool" style=" font-style: italic;">{{$array['author']}}</div>&nbsp
    <div class="cool" style="font-style: italic; color: #35848F; ">({{$array["data"]}})</div><br>
    <div class="cool">{{$array['text']}}</div><br>
</div>
<div class="accordion" id="accordionExample">
    <div style="background-color: white; border: white; margin-left:{{$array['nesting']*30}}px" class="card">
        <div style="background-color: white; border: white; margin-left:{{$array['nesting']*30}}px" class="card-header" id="heading{{$array['id']}}">
            <h2 class="mb-0">
                <button style="color: #35848F;margin-left:{{-$array['nesting']*30}}px" class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" aria-expanded="false" data-target="#collapse_{{$array['id']}}" aria-controls="collapse_{{$array['id']}}">
                    Ответить
                </button>
            </h2>
        </div>
        <div id="collapse_{{$array['id']}}" class="collapse" aria-labelledby="heading{{$array['id']}}" data-parent="#accordionExample">
            <div class="card-body">
                <form>
                   {{csrf_field()}}
                    <textarea required  name="text" id="text_id{{$array['id']}}" class="form-control"></textarea><br>
                    <input type="hidden" id="parent_id{{$array['id']}}" class="parent_id" name="parent_id" value="{{$array['id']}}">
                    <input type="hidden" id="nesting{{$array['id']}}" class="nesting" name="nesting" value="{{$array['nesting']}}">
                    <button id="{{$array['id']}}" type="submit" class="btn btn-light button1">Отправить</button>
                </form>
            </div>
        </div>
    </div>
<div id="comment{{$array['id']}}"></div>




