@extends('template')

@section('title')
    Publicações
@stop

@section('nome-pagina')
    Lista de publicações
@stop

@section('content')
	@if ($publicacoes->count() > 0)
	    <ul>
	        @foreach ($publicacoes as $e)
	            <li>{{ $e->titulo }} : <span>{{ $e->subtitulo }}</span> <a href="{{ route('pub.edit', ['id' => $e->id]) }}">Editar publicação</a></li>
	        @endforeach
	    </ul>
	@endif
@stop