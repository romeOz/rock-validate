<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class String
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class String extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть строкой',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть строкой',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}