<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterApoiosLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apoios', function (Blueprint $table) {
            $table->integer('posicao')->default(0);
        });
        Schema::table('links', function (Blueprint $table) {
            $table->integer('posicao')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apoios', function (Blueprint $table) {
            //
        });
        Schema::table('liks', function (Blueprint $table) {
            //
        });
    }
}
