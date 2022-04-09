<?php

namespace App\Tests;

/**
 *
 * Run PrestaShop version check
 */
interface TestInterface
{

    public static function getName();

    public static function getFixLink();

    public static function getDescription();

    public static function detect($url);

}
