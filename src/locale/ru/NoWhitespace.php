<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class NoWhitespace
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class NoWhitespace extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'в {{name}} не должно быть пробельных символов',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'в {{name}} должны быть пробельные символы',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значении'];
    }
}