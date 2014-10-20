<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Uploaded extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be an uploaded file',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be an uploaded file',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'file'];
    }
}