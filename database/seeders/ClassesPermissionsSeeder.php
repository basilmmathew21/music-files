<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ClassesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        Permission::create(['name' => 'edit classess']);
        Permission::create(['name' => 'delete classess']);
        Permission::create(['name' => 'add classess']);
        Permission::create(['name' => 'view classess']);

        $role = Role::findOrFail(3);
        $role->givePermissionTo('view classess');
        $role->givePermissionTo('add classess');
        $role->givePermissionTo('delete classess');
        $role->givePermissionTo('edit classess');
    }
}
