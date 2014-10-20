<?php

namespace rock\validate\locale\en;


use rock\date\DateTime;
use rock\validate\locale\Locale;

class Max extends Locale
{
    const INCLUSIVE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be lower than {{maxValue}}',
                self::INCLUSIVE => '{{name}} must be lower than or equals {{maxValue}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be lower than {{maxValue}}',
                self::INCLUSIVE => '{{name}} must not be lower than or equals {{maxValue}}',
            ]
        ];
    }

    public function defaultPlaceholders($maxValue = null, $inclusive = false)
    {
        $this->defaultTemplate = $inclusive ? static::INCLUSIVE : static::STANDARD;
        if ($maxValue instanceof \DateTime) {
            $maxValue = $maxValue->format('Y-m-d H:i:s');
        } elseif ($maxValue instanceof DateTime) {
            $maxValue = $maxValue->format($maxValue->format);
        }
        return [
            'name' => 'value',
            'maxValue' =>  $maxValue
        ];
    }
}