<?php

namespace rock\validate\locale\en;


use rock\date\DateTime;
use rock\validate\locale\Locale;

class Min extends Locale
{
    const INCLUSIVE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be greater than {{minValue}}',
                self::INCLUSIVE => '{{name}} must be greater than or equals {{minValue}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be greater than {{minValue}}',
                self::INCLUSIVE => '{{name}} must not be greater than or equals {{minValue}}',
            ]
        ];
    }

    public function defaultPlaceholders($minValue = null, $inclusive = false)
    {
        $this->defaultTemplate = $inclusive ? static::INCLUSIVE : static::STANDARD;
        if ($minValue instanceof \DateTime) {
            $minValue = $minValue->format('Y-m-d H:i:s');
        } elseif ($minValue instanceof DateTime) {
            $minValue = $minValue->format();
        }
        return [
            'name' => 'value',
            'minValue' =>  $minValue
        ];
    }
}