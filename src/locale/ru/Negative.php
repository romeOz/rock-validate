<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Negative
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Negative extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть отрицательным',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть отрицательным',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}