<?php

namespace App\Tests;

use App\Models\Project;

/**
 *
 * Run PrestaShop version check
 */
interface TestInterface
{

    /**
     * Get name of pentest to be saved in database
     *
     * @return void
     */
    public static function getName();

    /**
     * Get fix link for pentest to be saved in database
     *
     * @return void
     */
    public static function getFixLink();

    /**
     * Get description for pentest to be saved in database
     *
     * @return void
     */
    public static function getDescription();

    /**
     * Run detect function to start pentest
     *
     * @param  mixed $url
     * @return void
     */
    public static function detect(Project $project);

}
