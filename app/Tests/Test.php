<?php

namespace App\Tests;

class Test
{
    public static $name = 'Test';

    public static $fix_link = 'test';

    public static $description = 'test';

    public static function detect($url){
        return [
            'test_id' => 1,
            'test_name' => "PrestaShop version check",
            'result' => '1',
            'fix_link' => "http://link.cz"
        ];
    }
    
}