<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Captcha extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'captcha must be valid',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'captcha must not be valid',
            ]
        ];
    }
}