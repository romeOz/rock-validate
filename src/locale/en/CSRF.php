<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class CSRF extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'CSRF-token must be valid',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'CSRF-token must not be valid',
            ]
        ];
    }
}