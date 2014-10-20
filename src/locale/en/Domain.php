<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Domain extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be a valid domain',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must not be a valid domain',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'domain'];
    }
}