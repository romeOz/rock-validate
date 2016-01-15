<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Writable extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be writable',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be writable',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'file'];
    }
}