<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Date extends Locale
{
    const FORMAT = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'value must be date',
                self::FORMAT => '{{name}} must be a valid date. Sample format: {{format}}'
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'value must not be date',
                self::FORMAT => '{{name}} must not be a valid date in the format {{format}}'
            ]
        ];
    }

    public function defaultPlaceholders($format = null)
    {
        if (empty($format)) {
            return [
                'name' => 'value',
            ];
        }

        return [
            'name' => 'value',
            'format' =>  date($format, strtotime('2005-12-30 01:02:03'))
        ];
    }
}