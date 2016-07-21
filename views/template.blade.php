<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--
    Desenvolvido por Gabriel Lemos
    Contato: lemos.gabriel.dev@gmail.com - www.gabriellemos.com.br
    -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>@yield('title')</title>
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="{{ asset('js/awesomplete.min.js') }}"></script>
        <script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
        <script src="{{ asset('js/index.js') }}"></script>
    </head>

    <body>
        <header>
            <div class="container">
                <nav id="header-menu-nav">
                    <ul class="clearfix">
                        <li><a title="autores" href="{{ route('autor.lista') }}">Autores</a></li>
                        <li><a title="livros" href="{{ route('livro.lista') }}">Livros</a></li>
                        <li>Dicionários - inativo</li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <div class="content clearfix">
                <h1 class="titulo">@yield('nome-pagina')</h1>
                @if (Session::has('message'))
                    <div class="message-box {{ Session::has('class') ? session('class') : 'error' }}">
                        <p>{{ session('message') }}</p>
                    </div>
                @endif
                <div>@yield('content')</div>
            </div>
        </main>
        <footer>
            <div class="container">
                <p>Prova prática Praxis - Gabriel Lemos</p>
            </div>
        </footer>
    </body>
</html>