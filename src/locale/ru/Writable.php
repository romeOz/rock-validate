<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Writable
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Writable extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должен быть доступен для записи',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должен быть доступен для записи',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'файл'];
    }
}