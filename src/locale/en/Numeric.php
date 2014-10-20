<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Numeric extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be numeric',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be numeric',
            ]
        ];
    }
}