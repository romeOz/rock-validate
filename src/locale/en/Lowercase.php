<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Lowercase extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be lowercase',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be lowercase',
            ]
        ];
    }
}