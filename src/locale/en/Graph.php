<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Graph extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must contain only graphical characters',
                self::EXTRA => '{{name}} must contain only graphical characters and "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must not contain graphical characters',
                self::EXTRA => '{{name}} must not contain graphical characters or "{{additionalChars}}"'
            )
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'value', 'additionalChars' => $additionalChars];
    }
}