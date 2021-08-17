<?php

namespace Database\Seeders;

use App\Models\Spatie\Permission;
use App\Models\Spatie\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Administrator',
            'is_editable' => false,
        ]);

        $role->syncPermissions(Permission::all());
    }
}
