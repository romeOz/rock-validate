<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Required extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must not be empty',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must be empty',
            ]
        ];
    }
}