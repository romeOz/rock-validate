<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class FileExtensions
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class FileExtensions extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Расширение {{name}} должно быть: {{extensions}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'Расширение {{name}} не должно быть: {{extensions}}',
            ]
        ];
    }

    public function defaultPlaceholders($extensions = null)
    {
        if (is_array($extensions)) {
            $extensions = implode(', ', $extensions);
        }
        return [
            'name' => 'файл',
            'extensions' =>  $extensions
        ];
    }
}