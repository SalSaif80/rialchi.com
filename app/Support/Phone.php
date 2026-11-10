<?php

namespace App\Support;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

final class Phone
{
    public static function normalize(string $number, string $region = 'SA'): ?string
    {
        $util = PhoneNumberUtil::getInstance();
        try {
            $parsed = $util->parse($number, $region);

            return $util->isValidNumber($parsed) ? $util->format($parsed, PhoneNumberFormat::E164) : null;
        } catch (NumberParseException) {
            return null;
        }
    }

    public static function countries(): array
    {
        $util = PhoneNumberUtil::getInstance();
        $options = [];
        foreach ($util->getSupportedRegions() as $region) {
            $options[$region] = \Locale::getDisplayRegion('-'.$region, 'ar').' (+'.$util->getCountryCodeForRegion($region).')';
        }
        asort($options);

        return $options;
    }
}
