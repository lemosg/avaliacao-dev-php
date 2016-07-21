<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaAutore extends Model {

	# COLUNAS custom* DA TABELA livros QUE PODEM SER MASSIVAMENTE SALVAS -- nesse caso, todas
	protected $filable = ['id_publicacaos', 'id_autores'];

	/*
	* @objetivo: Preencher o objeto com a relação publicação > autor
	* @param: (array) $array >> propriedade => valor
	* @return: void
	*
	* @obs:
	*/
	public function exchangeArray($array) {
		if (!empty($array['id_publicacaos']) && !empty($array['id_autores'])){
			$this->id_publicacaos = $array['id_publicacaos'];
			$this->id_autores     = $array['id_autores'];
		}
	}
}