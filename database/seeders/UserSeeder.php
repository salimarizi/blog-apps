<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => Role::where('name', 'admin')->first()->id,
            'name' => 'admin',
            'email' => 'admin@blog.com',
            'password' => bcrypt('admin123')
        ]);
    }
}
