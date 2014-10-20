<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Arr
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Arr extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть массивом',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно быть массивом',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}