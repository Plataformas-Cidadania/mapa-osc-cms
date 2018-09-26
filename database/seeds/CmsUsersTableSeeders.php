<?php

use Illuminate\Database\Seeder;

class CmsUsersTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cms_users')->insert([
            'name' => 'Admin',
            'email' => 'admin@cms',
            'password' => bcrypt('123456'),
        ]);
    }
}
