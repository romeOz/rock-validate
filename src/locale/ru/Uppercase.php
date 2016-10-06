<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Uppercase
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Uppercase extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть в верхнем регистре',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть в верхнем регистре',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}