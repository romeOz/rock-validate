<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Closure
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Closure extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть анонимной функцией',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть анонимной функцией',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}