<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class FileSizeMax
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class FileSizeMax extends Locale
{
    const INCLUSIVE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Размер {{name}} должен быть меньше {{maxValue}} байт',
                self::INCLUSIVE => 'Размер {{name}} должен быть меньше или равен {{maxValue}} байт',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'Размер {{name}} не должен быть меньше {{maxValue}} байт',
                self::INCLUSIVE => 'Размер {{name}} не дожен быть меньше или равен {{maxValue}} байт',
            ]
        ];
    }

    public function defaultPlaceholders($maxValue = null, $inclusive = false)
    {
        $this->defaultTemplate = $inclusive ? static::INCLUSIVE : static::STANDARD;
        return [
            'name' => 'файл',
            'maxValue' =>  $maxValue
        ];
    }
}