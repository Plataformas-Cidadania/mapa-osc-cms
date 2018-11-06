<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsVersoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_versoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imagem')->nullable();
            $table->text('arquivo')->nullable();
            $table->integer('tipo_id')->nullable();
            $table->integer('integrante_id')->nullable();

            
            $table->integer('versao_id')->unsigned();
            $table->foreign('versao_id')->references('id')->on('versoes')->onDelete('cascade');

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
        Schema::drop('items_versoes');
    }
}
