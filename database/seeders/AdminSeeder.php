<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin\Admin::create([
            'name' => 'Admin',
            'email' => 'admin@restaurant.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);
    }
}
