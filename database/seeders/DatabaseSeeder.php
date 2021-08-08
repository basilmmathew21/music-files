<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use App\Models\User;
use App\Models\UserType;
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
        //create user types
        UserType::create([
            'user_type' => 'Super Admin'
        ]);
        UserType::create([
            'user_type' => 'Admin'
        ]);
        UserType::create([
            'user_type' => 'Tutor'
        ]);
        UserType::create([
            'user_type' => 'Student'
        ]);

        //create countries
        Country::create([
            'name' => 'India',
            'code' => '+91',
            'phone_code' => '+91',
            'is_active'   => 1      
        ]);

        // create demo users
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'phone' => '9999999999',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'country_id'=>1,
            'user_type_id'=>1,            
            'is_active'=>1
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '8888888888',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'country_id'=>1,
            'user_type_id'=>2,
            'is_active'=>1
        ]);
        User::create([
            'name' => 'Tutor',
            'email' => 'tutor@example.com',
            'phone' => '7777777777',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'country_id'=>1,
            'user_type_id'=>3,
            'is_active'=>1
        ]);
        User::create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'phone' => '6666666666',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'country_id'=>1,
            'user_type_id'=>4,
            'is_active'=>1
        ]);

        Currency::create([
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$'            
        ]);
        Currency::create([
            'code' => 'EUR',
            'name' => 'Euro',
            'symbol' => 'â‚¬'            
        ]);
        
    }
}
