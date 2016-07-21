@extends('template')

@section('title')
    Cadastro Autor
@stop

@section('nome-pagina')
    Cadastre um novo Autor
@stop

@section('content')
    <form method="post" action="{{ route('autor.store') }}">
        {!! csrf_field() !!}
        <label for="nome">Nome<sup>*</sup></label>
        <small>Mínimo de 3 letras</small>
        <input id="nome" type="text" class="nome" name="nome" value="{{ old('nome') }}" />
        <small class="errors">{{$errors->first('nome')}}</small>

        <label for="notacao">Notação</label>
        <small>*deve conter 3 letras</small>
        <input id="notacao" type="text" class="notacao" name="notacao" value="{{ old('notacao') }}" />
        <small class="errors">{{$errors->first('notacao')}}</small>
        <input type="submit" name="Salvar" class="btn" value="Salvar" />
    </form>
@stop