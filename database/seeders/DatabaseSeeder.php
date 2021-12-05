<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
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

        // User::create([
        //     'name' => 'Dominik',
        //     'email' => 'dominik@email.cz',
        //     'password' => '$2y$10$xv.rT6N5VFShT2UPWH4JputiizMxqsXclDsH0lTFERphkFBYAxLOa'
        // ]);

        // Project::create([
        //     'user_id' => 1,
        //     'name' => 'Weblift',
        //     'url' => 'https://weblift.cz',
        //     'slug' => 'weblift',
        //     'verified' => 0
        // ]);

        // Project::create([
        //     'user_id' => 1,
        //     'name' => 'Localps',
        //     'url' => 'http://localps.cz',
        //     'slug' => 'localps',
        //     'verified' => 0
        // ]);
    }
}
