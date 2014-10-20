<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Int extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be an integer number',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must not be an integer number',
            )
        ];
    }
}