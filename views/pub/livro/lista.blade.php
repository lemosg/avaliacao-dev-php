@extends('template')

@section('title')
    Livros
@stop

@section('nome-pagina')
    Lista de livros
@stop

@section('content')
	@if ($livros->count() > 0)
	    <ul>
	        @foreach ($livros as $e)
	            <li><span>{{ $e->titulo }}</span> - {{ $e->getAutores() }} - <a href="{{ route('livro.edit', ['id' => $e->id]) }}">Editar livro</a> - <a href="{{ route('livro.delete', ['id' => $e->id]) }}" class="deletar">Deletar livro</a></li>
	        @endforeach
	    </ul>
	@endif
    <a class="btn" title="Cadastrar novo livro" href="{{ route('livro.create') }}">Novo Livro</a>
@stop