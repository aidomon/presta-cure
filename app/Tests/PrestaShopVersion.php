<?php

namespace App\Tests;

class PrestaShopVersion
{
    public static function detect($url){
        return [
            'test_id' => 1,
            'test_name' => "PrestaShop version check",
            'result' => 1,
            'fix_link' => "http://link.cz"
        ];
    }
    
}