<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Digit extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must contain only digits (0-9)',
                self::EXTRA => '{{name}} must contain only digits (0-9) and "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} must not contain digits (0-9)',
                self::EXTRA => '{{name}} must not contain digits (0-9) or "{{additionalChars}}"'
            )
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'value', 'additionalChars' => $additionalChars];
    }
}