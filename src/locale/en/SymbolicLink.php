<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class SymbolicLink extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be a symbolic link',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be a symbolic link',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'file'];
    }
}