<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class FileExtensions extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Extension of {{name}} must be: {{extensions}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'Extension of {{name}} must not be: {{extensions}}',
            ]
        ];
    }

    public function defaultPlaceholders($extensions = null)
    {
        if (is_array($extensions)) {
            $extensions = implode(', ', $extensions);
        }
        return [
            'name' => 'file',
            'extensions' =>  $extensions
        ];
    }
}