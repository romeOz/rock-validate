<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Regex extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} contains invalid characters',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} does not contain invalid characters',
            )
        ];
    }
}