<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Object
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Object extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть объектом',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть объектом',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}