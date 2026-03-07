<?php

namespace App\Service;

use HTMLPurifier, HTMLPurifier_Config;

class HTMLPurifierService
{
    public static function purify(mixed $content)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('URI.SafeIframeRegexp', null);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true]);

        $purifier = new HTMLPurifier($config);

        return $purifier->purify($content);
    }
}