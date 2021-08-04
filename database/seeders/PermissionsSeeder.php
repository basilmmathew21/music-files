<?php

namespace Database\Seeders;

use App\Models\User;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema as FacadesSchema;
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

        // create demo users
        /* $user = User::create([
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
            'name' => 'tutor',
            'email' => 'tutor@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user = User::create([
            'name' => 'student',
            'email' => 'student@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]); */

        //Truncate current permissions
        FacadesSchema::disableForeignKeyConstraints();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();


        // create roles and assign existing permissions
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'tutor']);
        Role::create(['name' => 'student']);

        //Assign roles to the Users
        $superadmin = User::findOrFail(1);
        $superadmin->assignRole(['super-admin']);
        $admin = User::findOrFail(2);
        $admin->assignRole(['admin']);
        $tutor = User::findOrFail(3);
        $tutor->assignRole(['tutor']);
        $student = User::findOrFail(4);
        $student->assignRole(['student']);

        // create permissions
        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'view settings']);
        //Users
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'view users']);


        Permission::create(['name' => 'edit fee payment']);
        Permission::create(['name' => 'delete fee payment']);
        Permission::create(['name' => 'add fee payment']);
        Permission::create(['name' => 'view fee payment']);

        Permission::create(['name' => 'edit students']);
        Permission::create(['name' => 'delete students']);
        Permission::create(['name' => 'add students']);
        Permission::create(['name' => 'view students']);

        Permission::create(['name' => 'edit tutors']);
        Permission::create(['name' => 'delete tutors']);
        Permission::create(['name' => 'add tutors']);
        Permission::create(['name' => 'view tutors']);

        Permission::create(['name' => 'edit tutor enquiries']);
        Permission::create(['name' => 'delete tutor enquiries']);
        Permission::create(['name' => 'add tutor enquiries']);
        Permission::create(['name' => 'view tutor enquiries']);

        Permission::create(['name' => 'edit testimonials']);
        Permission::create(['name' => 'delete testimonials']);
        Permission::create(['name' => 'add testimonials']);
        Permission::create(['name' => 'view testimonials']);

        Permission::create(['name' => 'edit payments']);
        Permission::create(['name' => 'delete payments']);
        Permission::create(['name' => 'add payments']);
        Permission::create(['name' => 'view payments']);

        Permission::create(['name' => 'edit courses']);
        Permission::create(['name' => 'delete courses']);
        Permission::create(['name' => 'add courses']);
        Permission::create(['name' => 'view courses']);

        Permission::create(['name' => 'edit classes']);
        Permission::create(['name' => 'delete classes']);
        Permission::create(['name' => 'add classes']);
        Permission::create(['name' => 'view classes']);

        Permission::create(['name' => 'view sms']);
        Permission::create(['name' => 'view admin sms']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        //Admin Permissions
        $adminRole = Role::where('name', 'admin')->first();

        //Tutor Permissions
        $tutorRole = Role::where('name', 'tutor')->first();
        $tutorRole->givePermissionTo('view dashboard');
        $tutorRole->givePermissionTo('view students');
        $tutorRole->givePermissionTo('view sms');

        $tutorRole->givePermissionTo('view classes');
        $tutorRole->givePermissionTo('add classes');
        $tutorRole->givePermissionTo('delete classes');
        $tutorRole->givePermissionTo('edit classes');


        //Student Permissions
        $studentRole = Role::where('name', 'student')->first();
        $studentRole->givePermissionTo('view dashboard');
        $studentRole->givePermissionTo('view fee payment');
        $studentRole->givePermissionTo('add fee payment');
        $studentRole->givePermissionTo('view sms');

        $studentRole->givePermissionTo('view classes');
        $studentRole->givePermissionTo('view payments');
        $studentRole->givePermissionTo('add testimonials');
    }
}
