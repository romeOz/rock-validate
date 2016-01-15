<?php

namespace rock\validate\locale\en;



use rock\validate\locale\Locale;

class FileSizeBetween extends Locale
{
    const BOTH = 0;
    const LOWER = 1;
    const GREATER = 2;

    public function defaultTemplates()
    {
        return  [
            self::MODE_DEFAULT => [
                self::BOTH => 'Size of {{name}} must be between {{minValue}} and {{maxValue}} bytes',
                self::LOWER => 'Size of {{name}}  must be greater than {{minValue}} bytes',
                self::GREATER => 'Size of {{name}} must be lower than {{maxValue}} bytes',
            ],
            self::MODE_NEGATIVE => [
                self::BOTH => 'Size of {{name}} must not be between {{minValue}} and {{maxValue}} bytes',
                self::LOWER => 'Size of {{name}}  must not be greater than {{minValue}} bytes',
                self::GREATER => 'Size of {{name}} must not be lower than {{maxValue}} bytes',
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
            'name' => 'file',
            'minValue' =>  $minValue,
            'maxValue' => $maxValue
        ];
    }
}