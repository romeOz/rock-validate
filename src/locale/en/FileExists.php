<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class FileExists extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must exists',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must not exists',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'file'];
    }
}