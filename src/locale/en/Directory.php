<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Directory extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be a directory',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be a directory',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'value'];
    }
}