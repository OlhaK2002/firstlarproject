
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

<script src="{{ asset('js/jquery-3.5.1.js') }}" defer></script>
<script src="{{ asset('js/reply.js') }}" defer></script>

@php
    echo '<div id="comment0"></div>';
@endphp
    @foreach ($array as $key => $value)
        @if($key!=0)

            @for($i=0;$i<$value['nesting'];$i++)

                @php echo '<ul>'; @endphp
            @endfor
        @endif
                @php echo '<span style = "font-style: italic">'.$value["author"].'</span>&nbsp<span style="font-style: italic; color: lightseagreen">'.$value["data"].')</span></br>&nbsp &nbsp'.$value["text"].'

                                        <form>'.csrf_field().'
                                           <textarea name="text" id="text_id' . $value['id'] . '" class="form-control"></textarea></br>
                                            <input type="hidden" id="parent_id' . $value['id'] . '" class="parent_id" name="parent_id" value="' . $value['id'] . '">
                                            <input type="hidden" id="nesting' . $value['id'] . '" class="nesting" name="nesting" value="' . $value['nesting'] . '">
                                            <button id="' . $value['id'] . '" type="submit" class="btn">Отправить</button>
                                        </form>

                            <ul><div id="comment' . $value['id'] . '"></div></ul>';
                @endphp
        @if($key!=0)
            @for($i=0;$i<$value['nesting'];$i++)
               @php echo '</ul>'; @endphp
            @endfor
        @endif
    @endforeach

