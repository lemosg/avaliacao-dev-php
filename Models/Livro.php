<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends BaseModel {

	private $autoresInconsistentes = [];

	public $autores = [];

	# COLUNAS custom* DA TABELA livros QUE PODEM SER MASSIVAMENTE SALVAS -- nesse caso, todas
	protected $filable = ['id_publicacaos', 'capa', 'ISBN', 'paginas', 'resumo', 'observacao'];

	/*
	* @objetivo: Completar os dados do livro
	* @param: void
	* @return: void
	*
	* @obs:
	*/
	public function getCompleteInformation() {
		$this->retrievePublicacao();
		$this->retrieveAutores();
	}

	public function getAutores($return = '') {
		foreach ($this->autores as $autor) {
			if (empty($return))
				$return = $autor->nome;

			else
				$return .= ' - '.$autor->nome;
		}
		return $return;
	}

	/*
	* @objetivo: Completar os dados do livro com os dados da publicação relativa
	* @param: void
	* @return: void
	*
	* @obs:
	*/
	private function retrievePublicacao() {
		$pub = Publicacao::where('id', $this->id_publicacaos)->first();
		if(!empty($pub)) {
			$this->titulo    = $pub->titulo;
			$this->subtitulo = $pub->subtitulo;
		} else {
			$this->desgarrado = TRUE; # variável de controle de erro
		}

	}

	/*
	* @objetivo: Completar os dados do livro com os autores relativos
	* @param: void
	* @return: void
	*
	* @obs:
	*/
	private function retrieveAutores() {
		$listaAutores = ListaAutore::where('id_publicacaos', $this->id_publicacaos)->get();
		if ($listaAutores->count() > 0) {
			foreach ($listaAutores as $lista) {
				$autor = Autore::where('id', $lista->id_autores)->first();
				if (!empty($autor))
					$this->autores[] = $autor;

				else
					$this->autoresInconsistentes[] = $lista->id_autores;
			}
		} else {
			$this->semAutores = TRUE;  # variável de controle de erro
		}
	}


	/*
	* @objetivo: Verificar a ocorrência de incongruências no banco
	* @param: void
	* @return: boolean 	- TRUE if there is erro
	*					- FALSE if everything is OK
	*
	* @obs:
	*/
	public function is_errors() {
		if (isset($this->semAutores) || isset($this->desgarrado) || !empty($this->autoresInconsistentes))
			return TRUE;

		return FALSE;
	}

	/*
	* @objetivo: Alias inverso do método is_errors
	* @param: void
	* @return: boolean 	- FALSE if there is erro
	*					- TRUE if everything is OK
	*
	* @obs:
	*/
	public function is_everythingOK() {
		return !$this->is_errors();
	}

	/*
	* @objetivo: obter lista de autores id que possuem relacionamento mas não existem na tabela autor
	* @param: void
	* @return: (array) 	- int IDs
	*
	* @obs:
	*/
	public function get_autoresInconsistentes() {
		return $this->autoresInconsistentes;
	}
}