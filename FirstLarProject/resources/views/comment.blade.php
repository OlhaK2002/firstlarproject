@extends('welcome')
@section('comment')
    @parent

        <input type="hidden" id="parent_id0" class="parent" name="parent_id" value="0">
        <input type="hidden" id="nesting0" class="nesting" name="nesting" value="0">
    <button id="0" type="submit" class="btn">Отправить</button>
    </form>
@endsection

