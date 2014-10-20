<?php

namespace rock\validate\locale\en;


use rock\date\DateTime;
use rock\validate\locale\Locale;

class Between extends Locale
{
    const BOTH = 0;
    const LOWER = 1;
    const GREATER = 2;

    public function defaultTemplates()
    {
        return  [
            self::MODE_DEFAULT => [
                self::BOTH => '{{name}} must be between {{minValue}} and {{maxValue}}',
                self::LOWER => '{{name}} must be greater than {{minValue}}',
                self::GREATER => '{{name}} must be lower than {{maxValue}}',
            ],
            self::MODE_NEGATIVE => [
                self::BOTH => '{{name}} must not be between {{minValue}} and {{maxValue}}',
                self::LOWER => '{{name}} must not be greater than {{minValue}}',
                self::GREATER => '{{name}} must not be lower than {{maxValue}}',
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
        if ($minValue instanceof \DateTime) {
            $minValue = $minValue->format('Y-m-d H:i:s');
        } elseif ($minValue instanceof DateTime) {
            $minValue = $minValue->format($minValue->format);
        }

        if ($maxValue instanceof \DateTime) {
            $maxValue = $maxValue->format('Y-m-d H:i:s');
        } elseif ($maxValue instanceof DateTime) {
            $maxValue = $maxValue->format($maxValue->format);
        }
        return [
            'name' => 'value',
            'minValue' =>  $minValue,
            'maxValue' => $maxValue
        ];
    }
}