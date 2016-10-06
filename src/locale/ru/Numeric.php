<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Numeric
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Numeric extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть числом',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть числом',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return [
            'name' => 'значение'
        ];
    }
}