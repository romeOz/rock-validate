<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class File
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class File extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть файлом',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно быть файлом',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}