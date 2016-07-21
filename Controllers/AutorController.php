<?php
namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Autore;
use App\Models\ListaAutore;

use Session;
/*
 * Controller para os usuarios (clientes) logados
 *
 */
class AutorController extends Controller {

    # ROTAS
    public function index() {
        $autores = Autore::all();

        if ($autores->count() == 0) {
            Session::flash('message', 'Nenhum autor cadastrado no momento');
            Session::flash('class', 'alert');
        }

        return view('autor.lista', [
            'autores' => $autores,
        ]);
    }

    public function create() {
        return view('autor.create');
    }

    public function edit($id) {
        $autor = Autore::where('id', $id)->first();
        if (empty($autor)) {
            Session::flash('message', 'Autor não encontrado');
            Session::flash('class', 'error');
            return redirect()->route('autor.lista');
        }

        return view('autor.edit', [
            'autor' => $autor,
        ]);
    }


    # ROTAS TRANSPARENTES
    public function store(Request $r) {
        $dados = $r->all();

        $validator = NULL;

        if (!$this->validation($dados, $validator)) {
            return redirect()->route('autor.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $autor = new Autore();
        $autor->exchangeArray($dados);
        $autor->save();

        $msg = 'Autor ' .$autor->notacao.' - '.$autor->nome. ' cadastrado com sucesso';

        /*
        ESSA DEVERIA SER A FORMA CORRETA DE POVOAR A SESSÃO FLASH
        POIS O CÓDIGO FICA MAIS LEGÍVEL

        A UTILIZAÇÃO DO MÉTODO WITH ESTÁ AQUI APENAS PARA EXEMPLIFICAR SEU USO

        Session::flash('message', $msg);
        Session::flash('class', 'sucesso');
        */
        return redirect()->route('autor.lista')
            ->with(['message' => $msg, 'class' => 'sucesso']);
    }

    public function update(Request $r) {
        $dados = $r->all();

        $validator = NULL;

        if (!$this->validation($dados, $validator)) {
            return redirect()->route('autor.edit', ['id' => $dados['id']])
                        ->withErrors($validator)
                        ->withInput();
        }

        $autor = Autore::where('id', $dados['id'])->first();
        $autor->exchangeArray($dados);
        $autor->save();

        Session::flash('message', 'Autor atualizado com sucesso');
        Session::flash('class', 'sucesso');

        return redirect()->route('autor.lista');
    }

    public function delete($id) {
        if ($this->is_validoId($id)){
            $autor = Autore::where('id', $id)->first();
            if (!empty($autor)) {
                $listaAutores = ListaAutore::where('id_autores', $id)->get();
                foreach ($listaAutores as $lista) {
                    $lista->delete(); # REMOVE TODAS REFERENCIAS DE AUTOR NA LISTA DE AUTORES
                }

                $autor->delete();
                Session::flash('message', 'Autor deletado com sucesso');
                Session::flash('class', 'sucesso');
            } else {
                Session::flash('message', 'Autor não encontrado');
                Session::flash('class', 'error');
            }
        }

        return redirect()->route('autor.lista');
    }

    public function search(Request $r) {
        $retorno = [];
        $dados = $r->all();

        $autores = Autore::where('nome', 'like', $dados['value'].'%')->get();

        foreach ($autores as $autor) {
            $retorno[] = [
                'nome'   => $autor->nome,
                'codigo' => $autor->id,
            ];
        }

        return json_encode($retorno);
    }


    /************************
    *   PRIVATE FUNCTIONS   *
    ************************/

    private function validation($dados, &$validator = NULL) {
        if (is_array($dados)) {
            if (isset($dados['id'])) {
                $this->is_validoId($dados['id']);
                $id_flag = TRUE;
            }

            $validar = [
                'nome' => 'required|min:3',
            ];

            if (!empty($id_flag))
                $validar['id'] = 'required|numeric|exists:autores,id';

            $validator = Validator::make($dados, $validar);

            if (!$validator->fails())
                return TRUE;
        }

        Session::flash('message', 'Verifique os campos abaixo');
        Session::flash('class', 'error');

        return FALSE;
    }

    private function is_validoId($id) {
        if (!is_numeric($id)) {
            Session::flash('message', 'Erro no tipo do Identificador do autor');
            Session::flash('class', 'error');
            return redirect()->route('autor.lista');
        }

        return TRUE;
    }
}
