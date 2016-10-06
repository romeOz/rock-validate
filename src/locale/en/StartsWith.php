<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class StartsWith extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must start with ({{startValue}})',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not start with ({{startValue}})',
            ]
        ];
    }

    public function defaultPlaceholders($startValue = null)
    {
        return [
            'name' => 'value',
            'startValue' => $startValue
        ];
    }
}