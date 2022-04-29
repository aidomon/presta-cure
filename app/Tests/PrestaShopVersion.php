<?php

namespace App\Tests;

use App\Models\Test;

/**
 *
 * Run PrestaShop version check
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
     * @param  mixed $url
     * @return void
     */
    public static function detect($url)
    {
        $ps_files_v1_7 = array('/autoload.php', '/controllers/admin/AdminCarrierWizardController.php', '/classes/PrestaShopCollection.php', '/img/preston-login-wink@2x.png');
        $ps_files_v1_6 = array('/header.php', '/css/retro-compat.css.php', '/classes/Theme.php', '/admin/tabs/index.php', '/controllers/admin/AdminZonesController.php');
        $ps_files_v1_5 = array('/category.php', '/product.php', '/admin/uploadProductFile.php', '/classes/Backup.php', '/css/admin.css');
        $ps_files_v1_4 = array('/css/datePicker.css', '/admin/ajax_send_mail_test.php', '/pagination.php', '/classes/CacheFS.php', '/config/autoload.php');

        $ps_html = array('/name="generator"\s*content="PrestaShop"/i', '/var prestashop\s*=\s*{/i', '/Powered by PrestaShop/i');

        $positive_counter_v1_7 = self::checkHTMLOccurance($ps_html, $url);
        $positive_counter_v1_6 = $positive_counter_v1_7;
        $positive_counter_v1_5 = $positive_counter_v1_7;
        $positive_counter_v1_4 = $positive_counter_v1_7;

        $positive_counter_v1_7 = $positive_counter_v1_7 + self::checkFilesOccurance($ps_files_v1_7, $url);
        $positive_counter_v1_6 = $positive_counter_v1_6 + self::checkFilesOccurance($ps_files_v1_6, $url);
        $positive_counter_v1_5 = $positive_counter_v1_5 + self::checkFilesOccurance($ps_files_v1_5, $url);
        $positive_counter_v1_4 = $positive_counter_v1_4 + self::checkFilesOccurance($ps_files_v1_4, $url);

        if (self::getHeaders($url) == true) {
            ++$positive_counter_v1_7;
            ++$positive_counter_v1_6;
        }

        $max = max($positive_counter_v1_7, $positive_counter_v1_6);
        if ($max >= 3) {
            $result = '';
            switch ($max) {
                case $positive_counter_v1_6:
                    $result = "Webapp is running on PrestaShop 1.6";
                    break;
                case $positive_counter_v1_7:
                    $result = "Webapp is running on PrestaShop 1.7";
                    break;
                default:
                    $result = "Webapp is running on PrestaShop";
            }
            return [
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'result' => $result,
                'fix_link' => 'passed',
            ];
        } else {
            return [
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'result' => 'Webapp is probably not running on PrestaShop',
                'fix_link' => self::getFixLink(),
            ];
        }
    }

    /**
     * Check presence of specific files
     *
     * @param  mixed $array
     * @param  mixed $url
     * @return integer
     */
    private static function checkFilesOccurance($array, $url)
    {
        $counter = 0;
        foreach ($array as $file) {
            $file_check = curl_init($url . $file);
            curl_setopt($file_check, CURLOPT_NOBODY, true);
            curl_exec($file_check);
            $status_code = curl_getinfo($file_check, CURLINFO_HTTP_CODE);
            if ($status_code == 200 or $status_code == 403 or $status_code == 500) {
                ++$counter;
            }
            curl_close($file_check);
        }
        return $counter;
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

    /**
     * getHeaders
     *
     * @param  mixed $url
     * @return boolean
     */
    private static function getHeaders($url)
    {
        $header_check = curl_init();
        curl_setopt($header_check, CURLOPT_URL, $url);
        curl_setopt($header_check, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($header_check, CURLOPT_HEADER, 1);
        curl_setopt($header_check, CURLOPT_NOBODY, 1);
        $output = curl_exec($header_check);
        curl_close($header_check);

        $headers = [];
        $output = rtrim($output);
        $data = explode("\n", $output);
        $headers['status'] = $data[0];
        array_shift($data);

        foreach ($data as $part) {
            $middle = explode(":", $part, 2);
            if (!isset($middle[1])) {$middle[1] = null;}
            $headers[trim($middle[0])] = trim($middle[1]);
        }

        if (array_key_exists('Set-Cookie', $headers)) {
            if (preg_match('/Prestashop/i', $headers['Set-Cookie'])) {
                return true;
            }
        }
        return false;
    }

}
