<?php

namespace rock\validate\locale\ru;


use rock\date\DateTime;
use rock\validate\locale\Locale;

/**
 * Class Min
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Min extends Locale
{
    const INCLUSIVE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть больше {{minValue}}',
                self::INCLUSIVE => '{{name}} должно быть больше или равно {{minValue}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть больше {{minValue}}',
                self::INCLUSIVE => '{{name}} не должно быть больше или равно {{minValue}}',
            ]
        ];
    }

    public function defaultPlaceholders($minValue = null, $inclusive = false)
    {
        $this->defaultTemplate = $inclusive ? static::INCLUSIVE : static::STANDARD;
        if ($minValue instanceof \DateTime) {
            $minValue = $minValue->format('Y-m-d H:i:s');
        } elseif ($minValue instanceof DateTime) {
            $minValue = $minValue->format($minValue->format);
        }
        return [
            'name' => 'значение',
            'minValue' =>  $minValue
        ];
    }
}