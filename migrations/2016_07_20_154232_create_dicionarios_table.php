<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDicionariosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('dicionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_publicacaos');
            $table->text('capa');
            $table->string('edicao');
            $table->text('classificacao')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('dicionarios');
    }
}
