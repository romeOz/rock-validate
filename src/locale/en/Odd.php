<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Odd extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be an odd number',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must not be an odd number',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}