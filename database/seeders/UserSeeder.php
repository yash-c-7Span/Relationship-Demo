<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(['email' => "admin@demo.com"],[
            'name' => "Super Admin",
            'email' => "admin@demo.com",
            'password' => Hash::make("12345678"),
            'password_view' => "12345678",
            'is_active' => isset(User::STATUS['ACTIVE']) ? User::STATUS['ACTIVE'] : 0,
            'role' => User::ADMIN_ROLE,
        ]);
    }
}
