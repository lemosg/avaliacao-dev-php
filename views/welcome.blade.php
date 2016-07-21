<!DOCTYPE html>
<html>
    <head>
        <title>Praxis - Gabriel Lemos</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                font-weight: 100;
                font-family: 'Helvetica';
                color: #666;
            }

            .container {
                width: 80%;
                margin: auto;
            }

            .content {
                display: inline-block;
            }

            .title {
                font-size: 96px;
                font-family: 'Lato';
                text-align: center;
            }
            a {
                display: block;
                width: 200px;
                margin: 45px auto;
                background-color: #4b8cdc;
                text-align: center;
                padding: 15px 0;
                color: #FFF;
                text-decoration: none;
            }
            a:hover { background-color: #3232b9; }
            li { padding: 5px 0; line-height: 1.2 }
            footer { background-color: #666; color: #FFF; padding: 20px 0; margin-top: 50px }
        </style>
    </head>
    <body>
        <header>
            <h1 class="title">Praxis - Gabriel Lemos</h1>
        </header>
        <main class="container">
            <div class="content">
                <p>Essa seria a página de boas vindas ou de login do usuário. Nesse exemplo não usarei a feature básica de autenticação do laravel, então basta clicar no link a baixo e utilizar o exemplo.</p>
                <p>Feito utilzando Laravel 5, banco de dados MySQL - deve-se utilizar do php artisan migrate para gerar as tabelas contidas nesse exemplo, qualquer dúvida ou ajuda que precise pode entrar em contato, inclusive, me disponho a levar meu notebook para demonstração.</p>
                <p>Esse é só um exemplo de sistema, todo o foco do desenvolvimento foi na usabilidade e nem tudo está perfeito - foi testado apenas no chrome linux</p>
                <a title="Início" href="{{ route('pub.lista') }}">Comece o exemplo</a>
                <article>
                    <h3>Definições</h3>
                    <ul>
                        <li>Entende-se que um livro é de um e apenas um tipo de publicação, pois o livro não muda de titulo, subtitulo e autores ao longo de sua existência.</li>
                        <li>Entende-se também que uma publicação pode se referir a vários livros, pois cada livro pode possuir ISBN, Imagem de capa, número de páginas diferente (devido à: utilização de font ou tamanho de font diferente, tradução diferenteciada, etc) e resumo diferente (feito pela editora/stakeholders...)</li>
                        <li>Entende-se que podem existir publicações com nomes iguais, assim como autores (homonimos). No caso dos autores, uma nova notação será criada, mas para publicações seria mais difiicil analizar.<small>* deve-se repensar nesse quesito, ou impondo que publicações tenham título único ou criando algum identificador humanamente reconhecível</small></li>
                        <li>Entende-se que cada imagem de capa seja referente a um único item publicado, seja ele livro, dicionário. Logo sua informação não está contida na tabela publicação e sim nas filhas.</li>
                        <li>Sabe-se que para cada tabela no banco, deve existir um model correspondente no singular.<small>vide arquivo .inf na pasta <i>models</i></small></li>
                        <li>Não será implementado o módulo dicionário, tendo em vista que ele foi utilizado apenas como parâmetro para definir a arquitetura, e pelo fato de suas funcionalidades serem muito próximas do módulo livro exemplificado</li>
                        <li>As mensagens de erro não serão traduzidas nesse exemplo, mas basta trocar a configuração de linguagem para pt-br e criar os arquivos de internacionalização</li>
                        <li>2 códigos externos - JavaScript foram incluidos nesse exemplo o masked-inputs e o awesomplete, além claro do JQuery</li>
                        <li>Nem todo o css foi explorado, apenas alguns detalhes com inutito de demonstração</li>
                    </ul>
                </article>
                <hr/>
                <article>
                    <h2>Informações sobre a arquitetura definida:</h2>
                    <p>Devido a relação imutável entre uma publicação e seu conjunto de autores, a relação estipulada é entre publicação/autores, e não livro/autores</p>
                    <p>A escolha de uma única tabela para todas as publicações implica em facilidade na busca idependente do tipo. Único critério usado para essa divisão.</p>
                    <p>* Geralmente as informações sobre livro se aplicam a qualquer outro elemento filho da publicação.</p>
                </article>
            </div>
        </main>
        <footer>
            <div class="container">
                <p>Gabriel Lemos - lemos.gabriel.dev@gmail.com</p>
                <p>tempo de desenvolvimento aproximadamente 10hs</p>
            </div>
        </footer>
    </body>
</html>