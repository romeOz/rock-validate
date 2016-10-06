<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class FileMimeTypes extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Mime-type of {{name}} must be: {{mimeTypes}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'Mime-type of {{name}} must not be: {{mimeTypes}}',
            ]
        ];
    }

    public function defaultPlaceholders($mimeTypes = null)
    {
        return [
            'name' => 'file',
            'mimeTypes' =>  $mimeTypes
        ];
    }
}