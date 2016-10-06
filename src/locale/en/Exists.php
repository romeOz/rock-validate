<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Exists extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must exists',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not exists',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'file'];
    }
}