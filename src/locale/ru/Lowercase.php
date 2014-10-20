<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Lowercase
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Lowercase extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть в нижнем регистре',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть в нижнем регистре',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}