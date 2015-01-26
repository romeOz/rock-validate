<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

/**
 * Class Unique
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\en
 */
class Unique extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{value}} has already been taken',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{value}} not already been taken',
            ]
        ];
    }

    public function defaultPlaceholders($value = null)
    {
        if (isset($value)) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            $value = "{$value}";
        }
        return [
            'value' =>  $value
        ];
    }
}