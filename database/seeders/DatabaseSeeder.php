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

        User::create([
            'username' => 'Dominik',
            'email' => 'dominik@email.cz',
            'password' => '$2y$10$xv.rT6N5VFShT2UPWH4JputiizMxqsXclDsH0lTFERphkFBYAxLOa'
        ]);

        Project::create([
            'user_id' => 1,
            'name' => 'Weblift',
            'url' => 'https://weblift.cz',
            'slug' => 'weblift',
            'verified' => 1
        ]);

        Project::create([
            'user_id' => 1,
            'name' => 'Testps',
            'url' => 'http://testps.loc',
            'slug' => 'testps',
            'verified' => 1
        ]);

        User::create([
            'username' => 'Paja',
            'email' => 'paja@email.cz',
            'password' => '$2y$10$xv.rT6N5VFShT2UPWH4JputiizMxqsXclDsH0lTFERphkFBYAxLOa'
        ]);

        Project::create([
            'user_id' => 2,
            'name' => 'HyggeStyle',
            'url' => 'https://hyggestyle.cz',
            'slug' => 'hyggestyle',
            'verified' => 1
        ]);
    }
}
