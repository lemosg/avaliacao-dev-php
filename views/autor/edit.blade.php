@extends('template')

@section('title')
    Editar Autor
@stop

@section('nome-pagina')
    Edição do {{ $autor->nome }}
@stop

@section('content')
    <form method="post" action="{{ route('autor.update') }}">
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}
        <input type="hidden" name="id" value="{{ $autor->id }}" />
        <label for="nome">nome<sup>*</sup></label>
        <input type="text" id="nome" name="nome" value="{{ old('nome') !== NULL ? old('nome') : $autor->nome }}" />
        <small class="errors">{{$errors->first('nome')}}</small>

        <label for="notacao">Notação</label>
        <input type="text" id="notacao" name="notacao" value="{{ old('notacao') !== NULL ? old('notacao') : $autor->notacao }}" />
        <small class="errors">{{$errors->first('notacao')}}</small>
        <input type="submit" name="Salvar" class="btn" value="Salvar" />
    </form>
@stop