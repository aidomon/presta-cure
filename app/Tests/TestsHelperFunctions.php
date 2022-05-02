<?php

namespace App\Tests;

class TestsHelperFunctions
{
    /**
     * getHeaders
     *
     * @param $url
     * @return boolean
     */
    public static function getHeaders($url)
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
        return $headers;
    }

    /**
     * Check presence of specific files
     *
     * @param  mixed $array
     * @param  mixed $url
     * @return integer
     */
    public static function checkFilesOccurance($array, $url)
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
}
