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
        $classes = array_values(array_diff(scandir(__dir__), array('.DS_Store', '.', '..', 'LoadAllTests.php', 'TestInterface.php', 'TestsHelperFunctions.php')));

        if (in_array('PrestaShopVersion.php', $classes)) {
            $classes = array_values(array_diff($classes, ['PrestaShopVersion.php']));
            array_unshift($classes, 'PrestaShopVersion.php');
        }

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($classes as $class) {
            $class_name = strstr($class, '.', true);
            $instance = '\App\Tests\\' . $class_name;

            $test_type = new $instance;

            Test::updateOrCreate(
                [
                    'class' => $class_name,
                ],
                [
                    'name' => $test_type::getName(),
                    'description' => $test_type::getDescription(),
                    'fix_link' => $test_type::getFixLink(),
                ]
            );
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
