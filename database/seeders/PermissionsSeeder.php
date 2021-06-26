<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        Permission::create(['name' => 'view dashboard']);

        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'view users']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('view dashboard');
        $role2->givePermissionTo('view users');
        $role2->givePermissionTo('add users');

        $role3 = Role::create(['name' => 'user']);
        $role3->givePermissionTo('view dashboard');
        $role3->givePermissionTo('view users');

        // create demo users
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user = User::findOrFail(1);
        $user->assignRole(['super-admin']);
        $user = User::findOrFail(2);
        $user->assignRole(['admin']);
        $user = User::findOrFail(3);
        $user->assignRole(['user']);

        /*$role = Role::findOrFail(2);
        $role->givePermissionTo('view categories');
        $role->givePermissionTo('add categories');
        $role = Role::findOrFail(3);
        $role->givePermissionTo('view categories');
        $role->givePermissionTo('add categories');*/

    }
}
