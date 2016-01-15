<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Int
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class IntLocale extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть целым числом',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть целым числом',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}