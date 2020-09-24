@extends ('welcome')
@section('reply')

    @foreach ($array as $key => $value)

        @if($key!=0)

            @for($i=0;$i<$value['nesting'];$i++)

                @php echo '<ul>'; @endphp
            @endfor
        @endif

        @php echo '<span style = "font-style: italic">'.$value['author'].'</span>'. '&nbsp' .'<span style="font-style: italic; color: lightseagreen">'." (".$value['data'].") ".'</span>'.'</br>' .$value['text'].'<div class="accordion" id="accordionExample">';
             echo '<div class="accordion" id="accordionExample">
               <div class="card">
                 <div class="card-header" id="heading' . $value['id'] . '">
                    <h2 class="mb-0">
                     <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" aria-expanded="false" data-target="#collapse_' . $value['id']  . '" aria-controls="collapse_' . $value['id']  . '">
                      Ответить
                    </button>
                    </h2>
                 </div>
                 <div id="collapse_' . $value['id']  . '" class="collapse" aria-labelledby="heading' . $value['id']  . '" data-parent="#accordionExample">
                    <div class="card-body">
                    <form>
                    '.csrf_field().'
                          <textarea required name="text" id="text_id' . $value['id']  . '" class="form-control"></textarea></br>
                          <input type="hidden" id="parent_id' . $value['id']  . '" class="parent_id" name="parent_id" value="' . $value['id']  . '">
                          <input type="hidden" id="nesting' . $value['id']  . '" class="nesting" name="nesting" value="'.$value['nesting'].'">
                          <button id="' . $value['id']  . '" type="submit" class="btn btn-light">Отправить</button>
                    </form>
                    </div>
                 </div>
                </div><ul><div id="comment' . $value['id']  . '"></div></ul>';
        @endphp

        @if($key!=0)
            @for($i=0;$i<$value['nesting'];$i++)
               @php echo '</ul>'; @endphp
            @endfor
        @endif
    @endforeach
@endsection