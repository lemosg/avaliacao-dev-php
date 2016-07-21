@extends('template')

@section('title')
    Autores
@stop

@section('nome-pagina')
    Lista de autores
@stop

@section('content')
	@if ($autores->count() > 0)
	    <ul>
	        @foreach ($autores as $e)
	            <li><span>{{ $e->notacao }}</span> - {{ $e->nome }} - <a href="{{ route('autor.edit', ['id' => $e->id]) }}">Editar autor</a> - <a href="{{ route('autor.delete', ['id' => $e->id]) }}" class="deletar">Deletar autor</a></li>
	        @endforeach
	    </ul>
	@endif
    <a class="btn" title="Criar novo autor" href="{{ route('autor.create') }}">Novo Autor</a>
@stop