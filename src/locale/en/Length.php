<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Length extends Locale
{
    const BOTH = 0;
    const LOWER = 1;
    const GREATER = 2;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::BOTH => '{{name}} must have a length between {{minValue}} and {{maxValue}}',
                self::LOWER => '{{name}} must have a length greater than {{minValue}}',
                self::GREATER => '{{name}} must have a length lower than {{maxValue}}',
            ],
            self::MODE_NEGATIVE => [
                self::BOTH => '{{name}} must not have a length between {{minValue}} and {{maxValue}}',
                self::LOWER => '{{name}} must not have a length greater than {{minValue}}',
                self::GREATER => '{{name}} must not have a length lower than {{maxValue}}',
            ]
        ];
    }

    public function defaultPlaceholders($minValue = null, $maxValue = null)
    {
        if (!isset($minValue)) {
            $this->defaultTemplate = static::GREATER;
        } elseif (!isset($maxValue)) {
            $this->defaultTemplate = static::LOWER;
        } else {
            $this->defaultTemplate = static::BOTH;
        }
        return [
            'name' => 'value',
            'minValue' =>  $minValue,
            'maxValue' => $maxValue
        ];
    }
}