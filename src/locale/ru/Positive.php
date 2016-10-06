<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Positive
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Positive extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть положительным',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть положительным',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}