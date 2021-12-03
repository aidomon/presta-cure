<?php

namespace App\Tests;

use App\Models\Test;
use Illuminate\Support\Facades\DB;

class LoadAllTests
{
    /**
     * Load all tests in database.
     */
    public static function loadTests(): void
    {
        $classes = array_values(array_diff(scandir(__dir__), array('.', '..', 'LoadAllTests.php')));

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Test::truncate();

        foreach ($classes as $class) {
            $class_name = strstr($class, '.', true);
            $instance = 'App\Tests\\' . $class_name;

            $test_type = new $instance;

            Test::create([
                'name' => $test_type::$name,
                'description' => $test_type::$description,
                'fix_link' => $test_type::$fix_link,
                'class' => $class_name,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
