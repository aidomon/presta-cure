<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Tests\LoadAllTests;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::truncate();
        Project::truncate();

        LoadAllTests::loadTests();

        User::create([
            'username' => 'Admin',
            'email' => 'admin@email.cz',
            'password' => '$2y$10$/RxkMzp1hHCFgCCceQ6JEek4SQ0eeyVCBuV1J8P2bqLxOxoQhqitS',
        ]);
    }
}
