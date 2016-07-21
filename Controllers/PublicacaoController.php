<?php
namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Publicacao;

use Session;
/*
 * Controller para os usuarios (clientes) logados
 *
 */
class PublicacaoController extends Controller {


    # ROTAS
    public function index() {
        $pub = Publicacao::all();

         if ($pub->count() == 0) {
            Session::flash('message', 'Nenhum publicação cadastrada no momento');
            Session::flash('class', 'alert');
        }

        return view('pub.lista', [
            'publicacoes' => $pub,
        ]);
    }

    public function edit($id) {
        $pub = Publicacao::where('id', $id)->first();
        if (empty($pub)) {
            Session::flash('message', 'Publicação não encontrada');
            Session::flash('class', 'error');
            return redirect()->route('pub.lista');
        }

        return view('pub.edit', [
            'publicacao' => $pub,
        ]);
    }

    public function search(Request $r) {
        $retorno = [];
        $dados = $r->all();

        $pubs = Publicacao::where('titulo', 'like', $dados['value'].'%')->get();

        foreach ($pubs as $p) {
            $retorno[] = [
                'titulo' => $p->titulo,
                'extras' => json_encode(['id' => $p->id, 'subtitulo' => $p->subtitulo]),
            ];
        }

        return json_encode($retorno);
    }

    # ROTAS TRANSPARENTES
    public function update(Request $r) {
        $dados = $r->all();

        $validar = [
            'id'     => 'required|numeric|exists:autores,id',
            'titulo' => 'required',
        ];

        $validator = Validator::make($dados, $validar);

        if ($validator->fails()) {
            Session::flash('message', 'Verifique os campos abaixo');
            Session::flash('class', 'error');

            return redirect()->route('autor.edit', ['id' => $dados['id']])
                        ->withErrors($validator)
                        ->withInput();
        }

        $pub = Publicacao::where('id', $dados['id'])->first();
        $pub->exchangeArray($dados);
        $pub->save();

        Session::flash('message', 'Publicação atualizada com sucesso');
        Session::flash('class', 'sucesso');

        return redirect()->route('pub.lista');
    }
}
