<?php

namespace rock\validate\locale\ru;


use rock\date\DateTime;
use rock\validate\locale\Locale;

/**
 * Class FileSizeBetween
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class FileSizeBetween extends Locale
{
    const BOTH = 0;
    const LOWER = 1;
    const GREATER = 2;

    public function defaultTemplates()
    {
        return  [
            self::MODE_DEFAULT => [
                self::BOTH => 'Размер {{name}} должен быть в диапазоне между {{minValue}} и {{maxValue}} байт',
                self::LOWER => 'Размер {{name}} должен быть больше чем {{maxValue}} байт',
                self::GREATER => 'Размер {{name}} должен быть меньше чем {{maxValue}} байт',
            ],
            self::MODE_NEGATIVE => [
                self::BOTH => 'Размер {{name}} не должен быть в диапазоне между {{minValue}} и {{maxValue}} байт',
                self::LOWER => 'Размер {{name}} не должен быть больше чем {{maxValue}} байт',
                self::GREATER => 'Размер {{name}} не должен быть меньше чем {{maxValue}} байт',
            ]
        ];
    }

    public function defaultPlaceholders($minValue = null, $maxValue = null)
    {
        if (!isset($minValue)) {
            $this->defaultTemplate = static::GREATER;
        } elseif (!isset($maxValue)) {
            $this->defaultTemplate = static::LOWER;
        } else {
            $this->defaultTemplate = static::BOTH;
        }

        return [
            'name' => 'файл',
            'minValue' =>  $minValue,
            'maxValue' => $maxValue
        ];
    }
}