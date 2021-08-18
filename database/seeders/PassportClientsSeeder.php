<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'name' => 'Personal Access Client',
            'secret' => 'IUaqAjtnivEaxeACDwxFR33poujn5x5kkOVbutiP',
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => false,
        ]);

        DB::table('oauth_clients')->insert([
            'name' => 'Password Grant Client',
            'secret' => 'GgQ3MkHxL1Ta7pYZoLT3fdai0oFsjdfQLIAotUc4',
            'redirect' => 'http://localhost',
            'password_client' => 1,
            'personal_access_client' => 0,
            'revoked' => false,
        ]);
    }
}
