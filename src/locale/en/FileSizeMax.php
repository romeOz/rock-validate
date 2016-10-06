<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class FileSizeMax extends Locale
{
    const INCLUSIVE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Size of {{name}} must be lower than {{maxValue}} bytes',
                self::INCLUSIVE => 'Size of {{name}} must be lower than or equals {{maxValue}} bytes',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'Size of {{name}} must not be lower than {{maxValue}} bytes',
                self::INCLUSIVE => 'Size of {{name}} must not be lower than or equals {{maxValue}} bytes',
            ]
        ];
    }

    public function defaultPlaceholders($maxValue = null, $inclusive = false)
    {
        $this->defaultTemplate = $inclusive ? static::INCLUSIVE : static::STANDARD;
        return [
            'name' => 'file',
            'maxValue' =>  $maxValue
        ];
    }
}