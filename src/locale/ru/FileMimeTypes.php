<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class FileMimeTypes
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class FileMimeTypes extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Mime-type {{name}} должен быть: {{mimeTypes}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'Mime-type {{name}} не должен быть: {{mimeTypes}}',
            ]
        ];
    }

    public function defaultPlaceholders($mimeTypes = null)
    {
        return [
            'name' => 'файла',
            'mimeTypes' =>  $mimeTypes
        ];
    }
}