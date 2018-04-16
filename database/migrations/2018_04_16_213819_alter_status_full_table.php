<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatusFullTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('modulos', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('items', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('webdoors', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('mroscs', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('items_mroscs', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('noticias', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('links', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('versoes', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
        Schema::table('items_versoes', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos', function (Blueprint $table) {

        });
        Schema::table('modulos', function (Blueprint $table) {

        });
        Schema::table('items', function (Blueprint $table) {

        });
        Schema::table('webdoors', function (Blueprint $table) {

        });
        Schema::table('videos', function (Blueprint $table) {

        });
        Schema::table('mroscs', function (Blueprint $table) {

        });
        Schema::table('items_mroscs', function (Blueprint $table) {

        });
        Schema::table('noticias', function (Blueprint $table) {

        });
        Schema::table('links', function (Blueprint $table) {

        });
        Schema::table('versoes', function (Blueprint $table) {

        });
        Schema::table('items_versoes', function (Blueprint $table) {

        });
    }
}
