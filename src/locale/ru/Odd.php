<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Odd
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Odd extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть чётным числом',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно быть чётным числом',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}