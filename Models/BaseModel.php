<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

	/*
	* @objetivo: Preencher o objeto com os dados de um array
	* @param: (array) $array >> propriedade => valor
	* @return: void
	*
	* @obs: propriedades não definidas em filable, são setadas em formato json em observações
	*		pois assim, caso exista novas necessidades futuras pontuais, pode-se usar esse campo sem
	* 		a criaçaõ de novas colunas na tabela
	*/
	public function exchangeArray($array, $filable = NULL) {
		if (is_array($array)) {
			$fil = (is_null($filable)) ? $this->filable : $filable;

	   		$extras = array();
	   		foreach ($array as $key => $value) {
	   			if (in_array($key, $fil)) {
	   				$this->$key = $value;
	   			}

	   			else
	   				$extras[$key] = $value;
	   		}
	   		if (in_array('observacoes', $fil))
	   			$this->observacoes = (empty($this->extras)) ? NULL :json_encode($this->extras);
		}
	}
}