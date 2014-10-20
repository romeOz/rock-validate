<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Confirm extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'values must be equals',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'values must not be equals',
            ]
        ];
    }
}