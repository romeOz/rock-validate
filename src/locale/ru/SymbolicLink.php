<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class SymbolicLink
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class SymbolicLink extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должен быть символической ссылкой',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должен быть символической ссылкой',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'файл'];
    }
}