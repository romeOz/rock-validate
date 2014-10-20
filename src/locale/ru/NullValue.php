<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class NullValue
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class NullValue extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть NULL',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть NULL',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}