<?php

namespace App\Tests;

use App\Models\Project;

/**
 *
 * Interface to be implemented by every penetration test
 */
interface TestInterface
{

    /**
     * Get name of pentest to be saved in database
     *
     * @return string
     */
    public static function getName();

    /**
     * Get fix link for pentest to be saved in database
     *
     * @return string
     */
    public static function getFixLink();

    /**
     * Get description for pentest to be saved in database
     *
     * @return string
     */
    public static function getDescription();

    /**
     * Run detect function to start pentest
     *
     * @param  Project $project
     * @return json
     */
    public static function detect(Project $project);

}
