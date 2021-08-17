<?php

namespace Database\Seeders;

use App\Models\Spatie\Permission;
use Illuminate\Database\Seeder;

class UsersModulePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionName = 'users';
        $showName = "Users";

        Permission::create(['name' => "{$permissionName}.view", 'show_name' => "View {$showName}", 'guard_name' => 'api']);
        Permission::create(['name' => "{$permissionName}.create", 'show_name' => "Create {$showName}", 'guard_name' => 'api']);
        Permission::create(['name' => "{$permissionName}.edit", 'show_name' => "Edit {$showName}", 'guard_name' => 'api']);
        Permission::create(['name' => "{$permissionName}.delete", 'show_name' => "Delete {$showName}", 'guard_name' => 'api']);

    }
}
