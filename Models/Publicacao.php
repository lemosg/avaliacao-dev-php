<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacao extends BaseModel {

	# COLUNAS custom* DA TABELA publicacaos QUE PODEM SER MASSIVAMENTE SALVAS -- nesse caso, todas
	protected $filable = ['titulo', 'subtitulo', 'observacao'];

}