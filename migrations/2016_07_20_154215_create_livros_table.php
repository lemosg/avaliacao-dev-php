<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivrosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('livros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_publicacaos');
            $table->text('capa');
            $table->string('ISBN');
            $table->integer('paginas');
            $table->text('resumo')->nullable();
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
        Schema::drop('livros');
    }
}
