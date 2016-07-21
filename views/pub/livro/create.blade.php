@extends('template')

@section('title')
    Cadastro Livro
@stop

@section('nome-pagina')
    Cadastre um novo livro
@stop

@section('content')
    <form method="post" action="{{ route('livro.store') }}" id="create-livro" data-action="{{ route('autor.search') }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" name="publicacao_id" />

        <label for="search">Busque a publicação</label>
        <input id="search" type="text" name="search-pub" value="{{ old('search-pub') }}" data-action="{{ route('pub.search') }}"/>
        <label for="titulo">Titulo<sup>*</sup></label>
        <textarea id="titulo" type="text" class="titulo" name="titulo" >{{ old('titulo') }}</textarea>
        <small class="errors">{{$errors->first('titulo')}}</small>

        <label for="subtitulo">Subtitulo</label>
        <textarea id="subtitulo" type="text" class="subtitulo" name="subtitulo" >{{ old('subtitulo') }}</textarea>
        <small class="errors">{{$errors->first('subtitulo')}}</small>

        <label for="ISBN">ISBN<sup>*</sup></label>
        <input id="ISBN" type="text" class="ISBN" name="ISBN" value="{{ old('ISBN') }}" />
        <small class="errors">{{$errors->first('ISBN')}}</small>

        <label for="paginas">Número de Páginas<sup>*</sup></label>
        <input id="paginas" type="text" class="paginas" name="paginas" value="{{ old('paginas') }}" />
        <small class="errors">{{$errors->first('paginas')}}</small>

        <label for="resumo">Resumo</label>
        <textarea id="resumo" type="text" class="resumo" name="resumo" >{{ old('resumo') }}</textarea>
        <small class="errors">{{$errors->first('resumo')}}</small>

        <div id="autores">
            <label>Autores<sup>*</sup></label>
            <small>Pelo menos um autor</small>
            <div>
                <input id="a1" type="text" name="autores[1]" value="{{ old('autores[1]') }}" />
                <input id="a1id" type="hidden" name="autoresid[1]" value="{{ old('autoresid[1]') }}" />
            </div>
            <input id="more-autores" type="button" name="more" value="Adicionar outro autor" />
        </div>

        <label for="capa">Imagem da capa</label>
        <input id="capa" type="file" name="capa" />
        <small class="errors">{{$errors->first('capa')}}</small>
        <input type="submit" name="Salvar" class="btn" value="Salvar" />
    </form>
@stop