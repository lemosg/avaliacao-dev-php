@extends('template')

@section('title')
    Editar Publicação
@stop

@section('nome-pagina')
    Edição do {{ $publicacao->titulo }}
@stop

@section('content')
    <form method="post" action="{{ route('pub.update') }}">
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}
        <input type="hidden" name="id" value="{{ $publicacao->id }}" />
        <label for="titulo">Titulo<sup>*</sup></label>
        <textarea id="titulo" type="text" class="titulo" name="titulo" >{{ old('titulo') !== NULL ? old('titulo') : $publicacao->titulo }}</textarea>
        <small class="errors">{{$errors->first('titulo')}}</small>

        <label for="subtitulo">Subtitulo</label>
        <textarea id="subtitulo" type="text" class="subtitulo" name="subtitulo" >{{ old('subtitulo') !== NULL ? old('subtitulo') : $publicacao->subtitulo }}</textarea>
        <small class="errors">{{$errors->first('subtitulo')}}</small>

        <input type="submit" name="Salvar" class="btn" value="Salvar" />
    </form>
@stop