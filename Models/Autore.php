<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autore extends BaseModel {

	# COLUNAS custom* DA TABELA livros QUE PODEM SER MASSIVAMENTE SALVAS
	protected $filable = ['nome', 'notacao']; # nesse caso, todas

	/*
	* @objetivo: Preencher o objeto com a relação publicação > autor
	* @param: (array) $array >> propriedade => valor
	* @return: void
	*
	* @obs:
	*/
	public function exchangeArray($array, $arrayFil = NULL) {
		parent::exchangeArray($array, $this->filable);

		$this->validNotacao();
	}

	/************************
	*	PRIVATE FUNCTIONS 	*
	************************/

	/*
	* @objetivo: Garantir que atributo notacao é único no banco
	* @param: void
	* @return: void
	*
	* @obs: Se não for único, acrescenta a notação um valor inteiro
	*/
	private function validNotacao() {
		$this->correctNotacao(); # TODA notacao DEVE SER EM MAIÚSCULO

		$autores = self::where('notacao', 'like', $this->notacao.'%')->get();
		if ($autores->count() > 0) {
			$this->notacao = $this->notacao.$autores->count();
		}
	}

	/*
	* @objetivo: Corrigir possíveis valores errados da notacao
	*		exemplo:
	*				- Maior ou Menor do que 3 caracteres
	*				- Caraceteres em minusculo
	* @motivo: Javascript desabilitado pode gerar incongruencias no banco
	* @param: (array) $array >> propriedade => valor
	* @return: void
	*
	* @obs: Caso ocorra algum critério de erro, valor informado pelo usuário é ignorado
	*/
	private function correctNotacao() {
		if (empty($this->notacao) || strlen($this->notacao) != 3)
			$this->notacao = substr($this->nome, 0, 3);

		$this->notacao = strtoupper($this->notacao);
	}
}