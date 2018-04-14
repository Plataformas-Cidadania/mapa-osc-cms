<?php

use Illuminate\Database\Seeder;

class EquipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equipes')->insert([
            'cmsuser_id' => 1,
            'titulo' => 'Quem faz o Mapa',
            'sub_titulo' => 'Desenvolvimento, gestão e atualização do Mapa das OSCs',
            'descricao' => 'Texto',
        ]);
    }
}
