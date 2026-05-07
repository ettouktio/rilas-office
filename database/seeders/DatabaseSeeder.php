<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@rilas.test'],
            [
                'name' => 'RILAS Office Admin',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@rilas.test'],
            [
                'name' => 'RILAS Office Customer',
                'password' => 'password',
                'is_admin' => false,
            ]
        );

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
