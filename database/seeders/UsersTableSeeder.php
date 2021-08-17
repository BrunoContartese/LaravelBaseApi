<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'email' => 'bruno.a.contartese@gmail.com',
            'password' => Hash::make('secret'),
            'given_name' => 'Bruno',
            'family_name' => 'Contartese',
            'picture' => '',
        ];

        $this->createUser($user);
    }

    private function createUser($users)
    {
        try {
            DB::beginTransaction();
            $user = User::create($users);
            $user->syncRoles(["Administrator"]);
            DB::commit();
        } catch (\Exception $e) {
            Log::warning("Ha ocurrido un error (UsersTableSeeder): {$e->getMessage()}");
            throw $e;
        }
    }
}
