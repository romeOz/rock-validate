<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class FileSizeMin extends Locale
{
    const INCLUSIVE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} size must be greater than {{minValue}} bytes',
                self::INCLUSIVE => '{{name}} size must be greater than or equals {{minValue}} bytes',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} size must not be greater than {{minValue}} bytes',
                self::INCLUSIVE => '{{name}} size must not be greater than or equals {{minValue}} bytes',
            ]
        ];
    }

    public function defaultPlaceholders($minValue = null, $inclusive = false)
    {
        $this->defaultTemplate = $inclusive ? static::INCLUSIVE : static::STANDARD;
        return [
            'name' => 'file',
            'minValue' =>  $minValue
        ];
    }
}