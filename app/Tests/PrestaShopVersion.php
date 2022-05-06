<?php

namespace App\Tests;

use App\Models\Project;
use App\Models\Test;

/**
 *
 * Run PrestaShop version check
 *
 * DO NOT DELETE OR RENAME THIS PENTEST AS IT IS THE BASIS FOR ANOTHER PENTESTS
 */
class PrestaShopVersion implements TestInterface
{

    public static function getName()
    {
        return 'PrestaShop check';
    }

    public static function getFixLink()
    {
        return 'https://devdocs.prestashop.com/1.7/basics/keeping-up-to-date/upgrade/';
    }

    public static function getDescription()
    {
        return 'The PrestaShop check test is verifying that your targeted website is running on PrestaShop platform and which version. It is not infallible but it is required to run the tests against PrestaShop to get the best results possible.';
    }

    /**
     * Detect method
     *
     * @param  Project $project
     * @return json
     */
    public static function detect(Project $project)
    {
        $url = $project->url;

        $ps_files_v1_7 = array('/autoload.php', '/controllers/admin/AdminCarrierWizardController.php', '/classes/PrestaShopCollection.php', '/img/preston-login-wink@2x.png');
        $ps_files_v1_6 = array('/header.php', '/css/retro-compat.css.php', '/classes/Theme.php', '/admin/tabs/index.php', '/controllers/admin/AdminZonesController.php');
        $ps_files_v1_5 = array('/category.php', '/product.php', '/admin/uploadProductFile.php', '/classes/Backup.php', '/css/admin.css');
        $ps_files_v1_4 = array('/css/datePicker.css', '/admin/ajax_send_mail_test.php', '/pagination.php', '/classes/CacheFS.php', '/config/autoload.php');

        $ps_html = array('/name="generator"\s*content="PrestaShop"/i', '/var prestashop\s*=\s*{/i', '/Powered by PrestaShop/i');

        $positive_counter_v1_7 = self::checkHTMLOccurance($ps_html, $project->url);
        $positive_counter_v1_6 = $positive_counter_v1_7;
        $positive_counter_v1_5 = $positive_counter_v1_7;
        $positive_counter_v1_4 = $positive_counter_v1_7;

        $positive_counter_v1_7 = $positive_counter_v1_7 + TestsHelperFunctions::checkFilesOccurance($ps_files_v1_7, $url);
        $positive_counter_v1_6 = $positive_counter_v1_6 + TestsHelperFunctions::checkFilesOccurance($ps_files_v1_6, $url);
        $positive_counter_v1_5 = $positive_counter_v1_5 + TestsHelperFunctions::checkFilesOccurance($ps_files_v1_5, $url);
        $positive_counter_v1_4 = $positive_counter_v1_4 + TestsHelperFunctions::checkFilesOccurance($ps_files_v1_4, $url);

        if (self::checkPrestaShopCookie($url) == true) {
            ++$positive_counter_v1_7;
            ++$positive_counter_v1_6;
            ++$positive_counter_v1_5;
            ++$positive_counter_v1_4;
        }

        $max = max($positive_counter_v1_7, $positive_counter_v1_6, $positive_counter_v1_5, $positive_counter_v1_4);
        if ($max >= 3) {
            $result = '';
            switch ($max) {
                case $positive_counter_v1_7:
                    $result = "Webapp is running on PrestaShop 1.7";
                    break;
                case $positive_counter_v1_6:
                    $result = "Webapp is running on PrestaShop 1.6";
                    break;
                case $positive_counter_v1_5:
                    $result = "Webapp is running on PrestaShop 1.5";
                    break;
                case $positive_counter_v1_4:
                    $result = "Webapp is running on PrestaShop 1.4";
                    break;
                default:
                    $result = "Webapp is running on PrestaShop";
            }
            return json_encode([
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'info' => $result,
                'vulnerable' => true,
                'fix_link' => self::getFixLink(),
            ]);
        } else {
            return json_encode([
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'info' => 'Webapp is probably not running on PrestaShop',
                'vulnerable' => false,
            ]);
        }
    }

    /**
     * Check presence of specific html elements
     *
     * @param  mixed $array
     * @param  mixed $url
     * @return integer
     */
    public static function checkHTMLOccurance($array, $url)
    {
        $counter = 0;
        foreach ($array as $html) {
            $html_check = curl_init();
            curl_setopt($html_check, CURLOPT_URL, $url);
            curl_setopt($html_check, CURLOPT_RETURNTRANSFER, 1);
            if (preg_match($html, curl_exec($html_check))) {
                ++$counter;
            }
            curl_close($html_check);
        }
        return $counter;
    }

    public static function checkPrestaShopCookie($url)
    {
        $headers = TestsHelperFunctions::getHeaders($url);
        if (array_key_exists('Set-Cookie', $headers)) {
            if (preg_match('/Prestashop/i', $headers['Set-Cookie'])) {
                return true;
            }
        }
        return false;
    }
}
