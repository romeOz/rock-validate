<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class EndsWith extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must end with "{{endValue}}"',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not end with "{{endValue}}"',
            ]
        ];
    }

    public function defaultPlaceholders($endValue = null)
    {
        return [
            'name' => 'value',
            'endValue' => $endValue
        ];
    }
}