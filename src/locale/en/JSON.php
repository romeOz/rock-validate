<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class JSON extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be a valid JSON string',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be a valid JSON string',
            ]
        ];
    }
}