<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class NullValue extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be null',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be null',
            ]
        ];
    }
}