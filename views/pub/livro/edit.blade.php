@extends('template')

@section('title')
    Editar Livro
@stop

@section('nome-pagina')
    Edição do {{ $livro->titulo }}
@stop

@section('content')
    <form method="post" action="{{ route('livro.update') }}" id="create-livro" enctype="multipart/form-data">
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

        <input type="hidden" name="id" value="{{ $livro->id }}">

        <label for="titulo">Titulo<sup>*</sup></label>
        <p id="titulo">{{ $livro->titulo }}</p>


        <label for="subtitulo">Subtitulo</label>
        <p id="subtitulo">{{ $livro->subtitulo }}</p>

        <label for="ISBN">ISBN<sup>*</sup></label>
        <input id="ISBN" type="text" class="ISBN" name="ISBN" value="{{ old('ISBN') !== NULL ? old('ISBN') : $livro->ISBN }}" />
        <small class="errors">{{$errors->first('ISBN')}}</small>

        <label for="paginas">Número de Páginas<sup>*</sup></label>
        <input id="paginas" type="text" class="paginas" name="paginas" value="{{ old('paginas') !== NULL ? old('paginas') : $livro->paginas }}" />
        <small class="errors">{{$errors->first('paginas')}}</small>

        <label for="resumo">Resumo</label>
        <textarea id="resumo" type="text" class="resumo" name="resumo" >{{ old('resumo') !== NULL ? old('resumo') : $livro->resumo }}</textarea>
        <small class="errors">{{$errors->first('resumo')}}</small>

        <label>Autores</label>
        <p>{{ $livro->getAutores() }}</p>


        <label for="capa">Imagem da capa</label>
        <p>No caso a imagem não abre, pois deve-se configurar o Storage (aws por exemplo) ou criar um link simbolico para a pasta public ou ainda configura um novo Storage apontando para pasta public.</p>
        <img src="{{ $livro->capa }}">
        <input id="capa" type="file" name="capa" />
        <small class="errors">{{$errors->first('capa')}}</small>
        <input type="submit" name="Salvar" class="btn" value="Salvar" />
    </form>
@stop