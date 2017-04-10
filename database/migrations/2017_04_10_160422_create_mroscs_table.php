<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMroscsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mroscs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imagem');
            $table->string('titulo');
            $table->text('descricao');
            $table->text('arquivo');
            $table->text('slug');
            $table->integer('idioma_id')->unsigned();
            $table->foreign('idioma_id')->references('id')->on('idiomas')->onDelete('restrict');
            $table->integer('cmsuser_id')->unsigned();
            $table->foreign('cmsuser_id')->references('id')->on('cms_users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mroscs');
    }
}
