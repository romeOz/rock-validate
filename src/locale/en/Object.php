<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Object extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be an object',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be an object',
            ]
        ];
    }
}