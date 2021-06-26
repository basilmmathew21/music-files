<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create demo users
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Tutor',
            'email' => 'tutor@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

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

        $role3 = Role::create(['name' => 'tutor']);
        $role3->givePermissionTo('view dashboard');

        $role4 = Role::create(['name' => 'student']);
        $role4->givePermissionTo('view dashboard');

        User::findOrFail(1)->assignRole(['super-admin']);
        User::findOrFail(2)->assignRole(['admin']);
        User::findOrFail(3)->assignRole(['tutor']);
        User::findOrFail(4)->assignRole(['student']);
    }
}
