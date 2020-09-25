@extends('welcome')
@section('comment')
    @foreach ($array as $key => $value)
        @for($i=0;$i<$value['nesting'];$i++)
            <ul>
        @endfor
                <div id="comment0"></div>
                <span style="font-style: italic">{{ $value['author'] }}</span>&nbsp<span style="font-style: italic; color: #888988">({{ $value['data'] }})</span><br> &nbsp &nbsp{{ $value['text'] }}

                @if(session('login')!="")
                    <div class="accordion" id="accordionExample">
                        <div style="border: 	#FFFAF7;" class="card ">
                            <div style="background-color: 	#FFFAF7;" class="card-header"
                                 id="heading{{ $value['id'] }}">
                                <h2 class="mb-0">
                                    <button style="color: #888988;" class="btn btn-link btn-block text-left"
                                            type="button" data-toggle="collapse"
                                            aria-expanded="false" data-target="#collapse_{{ $value['id'] }}"
                                            aria-controls="collapse_{{ $value['id'] }}">
                                        Ответить
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse_{{ $value['id'] }}" class="collapse"
                                 aria-labelledby="heading{{ $value['id'] }}" data-parent="#accordionExample">
                                <div style="background-color: #FFFCF9;" class="card-body">
                                    <form>
                                        {{ csrf_field() }}
                                        <textarea style="background-color: #FFFCF9;" required name="text"
                                                  id="text_id{{ $value['id'] }}"
                                                  class="form-control"></textarea><br>
                                        <input type="hidden" id="parent_id{{ $value['id'] }}" class="parent_id"
                                               name="parent_id" value="{{ $value['id'] }}">
                                        <input type="hidden" id="nesting{{ $value['id'] }}" class="nesting"
                                               name="nesting"
                                               value="{{ $value['nesting'] }}">
                                        <button id="{{ $value['id'] }}" type="submit" class="btn btn-light">Отправить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <ul>
                            <div id="comment{{ $value['id'] }}"></div>
                        </ul>
                @endif
        @for($i=0;$i<$value['nesting'];$i++)
            </ul>
        @endfor
    @endforeach
@endsection

