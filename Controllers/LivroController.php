<?php
namespace App\Http\Controllers;

use Validator;
use Session;

use Storage;
use File;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Publicacao;
use App\Models\Autore;
use App\Models\ListaAutore;
use App\Models\Livro;


/*
 * Controller para os usuarios (clientes) logados
 *
 */
class LivroController extends Controller {

    # ROTAS
    public function index() {
        $livros = Livro::all();

        if ($livros->count() == 0) {
            Session::flash('message', 'Nenhum livro cadastrado no momento');
            Session::flash('class', 'alert');
        }
        foreach ($livros as $livro) {
            $livro->getCompleteInformation();
        }

        return view('pub.livro.lista', [
            'livros' => $livros,
        ]);
    }

    public function create() {
        return view('pub.livro.create');
    }

    public function edit($id) {
        $livro = Livro::where('id', $id)->first();
        if (empty($livro)) {
            Session::flash('message', 'Livro não encontrado');
            Session::flash('class', 'error');
            return redirect()->route('livro.lista');
        }

        $livro->getCompleteInformation();

        return view('pub.livro.edit', [
            'livro' => $livro,
        ]);
    }


    # ROTAS TRANSPARENTES
    public function store(Request $r) {
        $dados = $r->all();

        /* SE JA HOUVER PUBLICACÃO IGNORAR AUTORES */
        if (!empty($dados['publicacao_id'])) {
            $pub = Publicacao::where('id', $dados['publicacao_id'])->first();
            # alert personalizado quando publicação escolhida não puder ser encontrada
            if (empty($pub)) {
                Session::flash('message', 'Desculpe-nos, mas a publicação escolhida não foi encontrada');
                Session::flash('class', 'alert');
                return redirect()->route('livro.create')->withInput();
            }

            /*
            PODE-SE VALIDAR TITULO ENVIADO COM TITULO SALVO NO BANCO
            POR QUESTÕES DE REDUNDANCIA DE SEGURANÇA
            MAS NÃO SERÁ FEITO...
            EX:
            $dados['titulo'] == $pub->titulo

            ASSIM COMO COM O SUBTITULO
            */


            $validar = [
                'ISBN'    => 'required|unique:livros',
                'paginas' => 'required|numeric',
                'capa'    => 'mimes:jpeg,png',
            ];

            $validator = Validator::make($dados, $validar);

            if ($validator->fails()) {
                return redirect()->route('livro.create')
                            ->withErrors($validator)
                            ->withInput();
            }
        }

        # NOVA PUBLICAÇÃO
        else {

            $autor_escolhido = FALSE;
            if (!empty($dados['autoresid'])) {
                foreach ($dados['autoresid'] as $autor) {
                    if (!empty($autor))
                        $autor_escolhido = TRUE;
                }
            }


            # alert personalizado quando nenhum autor for escolhido
            if (!$autor_escolhido) {
                Session::flash('message', 'Escolha ao menos um autor');
                Session::flash('class', 'alert');
                return redirect()->route('livro.create')->withInput();
            }

            /* EH PRECISO VALIDAR TITULO PARA NOVA PUBLICAÇÃO */
            $validar = [
                'titulo'  => 'required',
                'ISBN'    => 'required|unique:livros',
                'paginas' => 'required|numeric',
                'capa'    => 'mimes:jpeg,png',
            ];

            $validator = Validator::make($dados, $validar);

            if ($validator->fails()) {
                return redirect()->route('livro.create')
                            ->withErrors($validator)
                            ->withInput();
            }

            /* SE NÂO HOUVER PUBLICAÇÂO */
            $array_pub = ['titulo' => $dados['titulo']];
            if (!empty($dados['subtitulo']))
                $array_pub['subtitulo'] =  $dados['subtitulo'];


            # CRIANDO NOVA PUBLICAÇÃO
            $pub = new Publicacao();
            $pub->exchangeArray($array_pub);
            $pub->save();

            /* CRIAR RELAÇÃO ENTRE PUBLICAÇÃO E AUTORES */
            foreach ($dados['autoresid'] as $a) {
                $autor = Autore::where('id', $a)->first();
                if (!empty($autor)) {
                    $lista = new ListaAutore();
                    $lista->exchangeArray(['id_publicacaos' => $pub->id, 'id_autores' => $autor->id]);
                    $lista->save();
                }
            }
        }
        # SALVAR CAPA
        /*
        * ESSA PARTE MERECE MAIS CUIDADO CRIANDO UM MODEL PARA GERENCIAR STORAGE
        * COM ISSO PODEMOS GERAR MELHORES NOMES DE ARQUIVOS
        * MELHORES LUGARES PARA SALVAR
        * E TROCAR FACILMENTE DE STORAGE SE FOR NECESSÁRIO
        * MAS NÃO SERÁ IMPLEMENTADO NESSA VERSÃO obs: não utilizei uma classe que já fiz para isso, deixando a funcionalidade bem raw
        */
        if (!empty($dados['capa'])){
            $fileName =  str_replace(' ', '_', $dados['titulo']).'.'.$dados['capa']->getClientOriginalExtension();
            Storage::disk()->put($fileName,  File::get($dados['capa']));
            $dados['capa'] = storage_path().$fileName;
        }

        $dados['id_publicacaos'] = $pub->id; # cria relação

        $livro = new Livro();
        $livro->exchangeArray($dados);
        $livro->save();

        Session::flash('message', 'Livro cadastrado com sucesso');
        Session::flash('class', 'sucesso');

        return redirect()->route('livro.lista');
    }

    public function update(Request $r) {
        $dados = $r->all();

        $validar = [
            'id'      => 'required|numeric|exists:livros,id',
            'ISBN'    => 'required|unique:livros',
            'paginas' => 'required|numeric',
            'capa'    => 'mimes:jpeg,png',
        ];

        $validator = Validator::make($dados, $validar);

        if ($validator->fails()) {
            return redirect()->route('livro.edit', ['id' => $dados['id']])
                        ->withErrors($validator)
                        ->withInput();
        }


        $livro = Livro::where('id', $dados['id'])->first();
        $livro->exchangeArray($dados);
        $livro->save();

        Session::flash('message', 'Livro atualizado com sucesso');
        Session::flash('class', 'sucesso');

        return redirect()->route('livro.lista');
    }

    public function delete($id) {
        $livro = Livro::where('id', $id)->first();
        if (!empty($livro)) {
            $livro->delete();
            Session::flash('message', 'Livro deletado com sucesso');
            Session::flash('class', 'sucesso');
        } else {
            Session::flash('message', 'Livro não encontrado');
            Session::flash('class', 'error');
        }

        return redirect()->route('livro.lista');
    }

}
