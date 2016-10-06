<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Email extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be valid',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be valid',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'email'];
    }
}