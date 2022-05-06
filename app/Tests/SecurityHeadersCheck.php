<?php

namespace App\Tests;

use App\Models\Project;
use App\Models\Test;

/**
 *
 * Run PrestaShop version check
 */
class SecurityHeadersCheck implements TestInterface
{

    public static function getName()
    {
        return 'Security Headers check';
    }

    public static function getFixLink()
    {
        return 'https://owasp.org/www-project-secure-headers/';
    }

    public static function getDescription()
    {
        return '<p>The Security Headers check test is verifying that your targeted website is secured with security headers such as:</p><ul style="margin-left:2%">' .
            '<li>HSTS - helps to protect websites against protocol downgrade attacks and cookie hijacking</li>' .
            '<li>X-Frame-Options - improves the protection of web applications against clickjacking</li>' .
            '<li>X-Content-Type-Options - prevents the browser from interpreting files as a different MIME type to what is specified in the Content-Type HTTP header</li>' .
            '<li>Referrer-Policy - governs which referrer information, sent in the Referer header, should be included with requests made</li>' .
            '<li>Content-Security-Policy - prevents a wide range of attacks, including cross-site scripting and other cross-site injections</li>' .
            '<li>Permissions-Policy - allows sites to more tightly restrict which origins can be granted access to features</li>' .
            '</ul>';
    }

    /**
     * Detect method
     *
     * @param  Project $project
     * @return json
     */
    public static function detect(Project $project)
    {
        $result = self::checkHeader(TestsHelperFunctions::getHeaders($project->url));
        if (strlen($result) > 0) {
            return json_encode([
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'info' => 'These security headers are missing: ' . $result,
                'vulnerable' => true,
                'fix_link' => self::getFixLink()
            ]);
        } else {
            return json_encode([
                'test_id' => Test::where('name', self::getName())->first()->id,
                'test_name' => self::getName(),
                'info' => 'Webapp contains all searched security headers',
                'vulnerable' => false
            ]);
        }

    }

    private static function checkHeader($headers)
    {
        $missing_security_headers = '';
        $headers_regex = array(
            'HSTS' => '/strict-transport-security/i',
            'X-Frame-Options' => '/X-Frame-Options/i',
            'X-Content-Type-Options' => '/X-Content-Type-Options/i',
            'Referrer-Policy' => '/referrer-policy/i',
            'Content-Security-Policy' => '/Content-Security-Policy/i',
            'Permissions-Policy' => '/permissions-policy/i'
        );

        foreach ($headers_regex as $key => $value) {
            if (self::preg_array_key_exists($value, $headers) == 0) {
                $missing_security_headers .= $key . ', ';
            }
        }
        return rtrim($missing_security_headers, ', ');
    }

    private static function preg_array_key_exists($pattern, $array)
    {
        $keys = array_keys($array);
        return (int) preg_grep($pattern, $keys);
    }
}
