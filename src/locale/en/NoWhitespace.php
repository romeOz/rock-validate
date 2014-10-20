<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class NoWhitespace extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must not contain whitespace',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must contain whitespace',
            )
        ];
    }
}