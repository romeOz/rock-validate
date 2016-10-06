<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Uploaded
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Uploaded extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должен быть загружен',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должен быть загружен',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'файл'];
    }
}