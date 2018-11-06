<?php

use Illuminate\Database\Seeder;

class IdiomaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('idiomas')->insert([
            'imagem' => '',
            'titulo' => 'Português (Brasil)',
            'sigla' => 'pt_BR',
            'cmsuser_id' => 1,
        ]);
    }
}
