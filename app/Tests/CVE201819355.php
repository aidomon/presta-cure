<?php

namespace App\Tests;

use App\Models\Test;
use App\Models\Result;
use App\Models\Project;

/**
 *
 * Run test for CVE-2018-19355 vulnerability
 */
class CVE201819355 implements TestInterface
{

    public static function getName()
    {
        return 'CVE-2018-19355';
    }

    public static function getFixLink()
    {
        return 'http://prestacure.loc/dashboard/tests#cve-2018-19355';
    }

    public static function getDescription()
    {
        return 'Security vulnerability ranked as high (7.5/10) which occurs in the module OrderFiles for PrestaShop (1.5 through 1.7) allows remote attackers to execute arbitrary code by uploading a php file via modules/orderfiles/upload.php with auptype equal to product (for upload destinations under modules/productfiles), order (for upload destinations under modules/files), or cart (for upload destinations under modules/cartfiles).<br>Solution for this vulnerability is update the module or remove or fix vulnerable files.';
    }

    /**
     * Detect method
     *
     * @param  Project $project
     * @return json
     */
    public static function detect(Project $project)
    {
        $prestashop_version = Result::getPrestaShopVersion($project->id);

        if ($prestashop_version == '1.5' || $prestashop_version == '1.6' || $prestashop_version == '1.7') {
            if (TestsHelperFunctions::checkFilesOccurance(array('/modules/orderfiles/upload.php'), $project->url) > 0) {
                return json_encode([
                    'test_id' => Test::where('name', self::getName())->first()->id,
                    'test_name' => self::getName(),
                    'info' => 'Webapp may be vulnerable as it uses vulnerable OrderFiles addon - update it',
                    'vulnerable' => true,
                    'fix_link' => self::getFixLink()
                ]);
            } else {
                return json_encode([
                    'test_id' => Test::where('name', self::getName())->first()->id,
                    'test_name' => self::getName(),
                    'info' => 'Webapp doesn\'t use OrderFiles addon',
                    'vulnerable' => false,
                ]);
            }
        } else {
            return json_encode([
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'info' => 'Run PrestaShop version check first for more precise result',
                'vulnerable' => false
            ]);
        }

    }
}
