<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Space extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must contain only space characters',
                self::EXTRA => '{{name}} must contain only space characters and "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not contain space characters',
                self::EXTRA => '{{name}} must not contain space characters or "{{additionalChars}}"'
            ]
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'value', 'additionalChars' => $additionalChars];
    }
}