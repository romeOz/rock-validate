<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Arr extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be an array',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must not be an array',
            )
        ];
    }
}