<?php

namespace App\Tests;

/**
 * 
 * Run PrestaShop version check
 */
class PrestaShopVersion
{
    public static $name = 'PrestaShop check';

    public static $fix_link = 'https://www.prestashop.com/en/blog/how-to-install-prestashop';

    public static $description = 'The PrestaShop check test is verifying that your targeted website is running on PrestaShop platform. It is not infallible but it is required to run the tests against PrestaShop to get the best results';

    public static function detect($url)
    {
        $ps_files = array('/controllers/admin/AdminCarrierWizardController.php', '/classes/PrestaShopCollection.php', '/img/preston-login-wink@2x.png');

        $ps_html = array('/name="generator"\s*content="PrestaShop"/i', '/var prestashop\s*=\s*{/i', '/Powered by PrestaShop/i');

        $positive_counter = 0;

        // check presence of specific files
        foreach ($ps_files as $file) {
            $file_check = curl_init($url . $file);
            curl_setopt($file_check, CURLOPT_NOBODY, true);
            curl_exec($file_check);
            $status_code = curl_getinfo($file_check, CURLINFO_HTTP_CODE);
            if ($status_code == 200 or $status_code == 403 or $status_code == 500) {
                ++$positive_counter;
            }
            curl_close($file_check);
        }

        // check presence of specific html elements
        foreach ($ps_html as $html) {
            $html_check = curl_init();
            curl_setopt($html_check, CURLOPT_URL, $url);
            curl_setopt($html_check, CURLOPT_RETURNTRANSFER, 1);
            if (preg_match($html, curl_exec($html_check))) {
                ++$positive_counter;
            }
            curl_close($html_check);
        }

        if (PrestaShopVersion::getHeaders($url) == true) {
            ++$positive_counter;
        }

        if ($positive_counter >= 2) {
            return [
                'test_id' => 1,
                'test_name' => PrestaShopVersion::$name,
                'result' => 'Webapp is running on PrestaShop',
                'fix_link' => 'null',
            ];
        } else {
            return [
                'test_id' => 1,
                'test_name' => PrestaShopVersion::$name,
                'result' => 'Webapp is probably not running on PrestaShop',
                'fix_link' => PrestaShopVersion::$fix_link,
            ];
        }
    }

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
