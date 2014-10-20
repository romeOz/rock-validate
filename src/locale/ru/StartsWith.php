<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class StartsWith
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class StartsWith extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно начинаться с "{{startValue}}"',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно начинаться с "{{startValue}}"',
            ]
        ];
    }

    public function defaultPlaceholders($startValue = null)
    {
        return [
            'name' => 'значение',
            'startValue' => $startValue
        ];
    }
}