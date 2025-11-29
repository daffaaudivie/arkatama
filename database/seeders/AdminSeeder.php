<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin 01',
            'email' => 'daffa.audivie27@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}
