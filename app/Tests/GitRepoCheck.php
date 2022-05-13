<?php

namespace App\Tests;

use App\Models\Test;
use App\Models\Project;

/**
 *
 * Run PrestaShop version check
 */
class GitRepoCheck implements TestInterface
{

    public static function getName()
    {
        return 'Git file presence check';
    }

    public static function getFixLink()
    {
        return 'https://iosentrix.com/blog/git-source-code-disclosure-vulnerability/';
    }

    public static function getDescription()
    {
        return 'This test scans the web application root for the .git file, which developers often forgot to delete or accidentally upload on the web. With this file an attacker can restore the source code of the application and find some confidential data.';
    }

    public static function detect(Project $project)
    {
        if (TestsHelperFunctions::checkFilesOccurance(array('/.git'), $project->url) > 0) {
            return json_encode([
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'info' => 'Webapp contains .git file - delete it',
                'vulnerable' => true,
                'fix_link' => self::getFixLink()
            ]);
        } else {
            return json_encode([
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'info' => 'Webapp doesn\'t contain .git file',
                'vulnerable' => false,
            ]);
        }
    }
}
