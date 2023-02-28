<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Khaled Allam',
            'email' => $email = 'khaled.allam@harbico.com',
            'username' => (explode('@', $email))[0],
        ]);
    }
}
