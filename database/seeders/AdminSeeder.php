<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            [
                'name'  => 'yoga ganteng',
                'email' => 'admin@yoga.com',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'password'   => Hash::make('admin123'),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]
        ]);

        User::insert([
            [
                'name'  => 'rizki ganteng',
                'email' => 'admin@rizki.com',
                'role'  => Role::Admin,
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'password'   => Hash::make('admin123'),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]
        ]);
    }
}
