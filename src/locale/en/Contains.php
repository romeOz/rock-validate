<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Contains extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must contain the value "{{containsValue}}"',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not contain the value "{{containsValue}}"',
            ]
        ];
    }

    public function defaultPlaceholders($containsValue = null)
    {
        return [
            'name' => 'value',
            'containsValue' => $containsValue
        ];
    }
}