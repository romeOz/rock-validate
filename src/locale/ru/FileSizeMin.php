<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class FileSizeMin
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class FileSizeMin extends Locale
{
    const INCLUSIVE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'Размер {{name}} должен быть больше {{minValue}} байт',
                self::INCLUSIVE => 'Размер {{name}} должен быть больше или равен {{minValue}} байт',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'Размер {{name}} не должен быть больше {{minValue}} байт',
                self::INCLUSIVE => 'Размер {{name}} не дожен быть больше или равен {{minValue}} байт',
            ]
        ];
    }

    public function defaultPlaceholders($minValue = null, $inclusive = false)
    {
        $this->defaultTemplate = $inclusive ? static::INCLUSIVE : static::STANDARD;
        return [
            'name' => 'файл',
            'minValue' =>  $minValue
        ];
    }
}