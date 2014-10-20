<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Readable extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be readable',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must not be readable',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'file'];
    }
}