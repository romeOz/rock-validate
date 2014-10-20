<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Regex
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Regex extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} содержит неверные символы',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не содержит верные символы',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}