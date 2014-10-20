<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Readable
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Readable extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должен быть доступен для чтения',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должен быть доступен для чтения',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'файл'];
    }
}