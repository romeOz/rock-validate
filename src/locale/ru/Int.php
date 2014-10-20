<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Int
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Int extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть целым числом',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно быть целым числом',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}