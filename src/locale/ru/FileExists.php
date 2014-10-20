<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class FileExists
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class FileExists extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должен существовать',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должен существовать',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'файл'];
    }
}