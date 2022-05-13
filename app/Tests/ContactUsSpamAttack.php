<?php

namespace App\Tests;

use App\Models\Project;
use App\Models\Result;
use App\Models\Test;
use DOMDocument;

/**
 *
 * Checks wether a PrestaShop web application can be vulnerable against Contact Us spam attack
 */
class ContactUsSpamAttack implements TestInterface
{

    public static function getName()
    {
        return 'Contact Us Spam Attack';
    }

    public static function getFixLink()
    {
        return 'https://elasticemail.com/blog/how-to-prevent-bots-from-spamming-your-sign-up-forms';
    }

    public static function getDescription()
    {
        return 'Checks wether a PrestaShop web application can be vulnerable against Contact Us spam attack, which could be present in PrestaShop versions 1.6.0.9-1.6.1.16 and allowed too generate unlimitted number of HTTP POST requests to flood admins mailbox.';
    }

    public static function detect(Project $project)
    {
        $prestashop_version = Result::getPrestaShopVersion($project->id);

        if ($prestashop_version == '1.6' || $prestashop_version == '1.5' || $prestashop_version == '1.4') {
            if (self::checkCSRFTokenOccurance($project->url)) {
                return json_encode([
                    'test_id' => Test::where('name', self::getName())->first()->id,
                    'test_name' => self::getName(),
                    'info' => 'Webapp seems to be protected by CSRF token',
                    'vulnerable' => false,
                ]);
            } else {
                return json_encode([
                    'test_id' => Test::where('name', self::getName())->first()->id,
                    'test_name' => self::getName(),
                    'info' => 'Webapp is vulnerable',
                    'vulnerable' => true,
                    'fix_link' => self::getFixLink(),
                ]);
            }
        }
        return json_encode([
            'test_id' => Test::where('name', self::getName())->first()->id,
            'test_name' => self::getName(),
            'info' => 'Webapp shouldn\'t be vulnerable. But to be sure, check if the contact form implements CSRF token or other security measures',
            'vulnerable' => true,
            'fix_link' => self::getFixLink(),
        ]);
    }

    /**
     * checkCSRFTokenOccurance
     *
     * @param  mixed $url
     * @return boolean
     */
    public static function checkCSRFTokenOccurance($url)
    {
        $url = $url . '/?controller=contact&submitMessage=1&message=nejakaSpamZprava&from=test@test.cz&id_contact=1';
        libxml_use_internal_errors(true);
        $document = new DOMDocument;
        $document->loadHTMLFile($url);

        $node_list = $document->getElementsByTagName('input');

        foreach ($node_list as $node) {
            if ($node->hasAttribute('type') && $node->hasAttribute('name') && $node->hasAttribute('value')) {
                if ($node->getAttribute('type') === 'hidden' && $node->getAttribute('name') === '_token') {
                    return true;
                }
            }
        }
        return false;
    }
}
