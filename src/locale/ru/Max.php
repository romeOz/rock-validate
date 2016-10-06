<?php

namespace rock\validate\locale\ru;


use rock\date\DateTime;
use rock\validate\locale\Locale;

/**
 * Class Max
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Max extends Locale
{
    const INCLUSIVE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть меньше {{maxValue}}',
                self::INCLUSIVE => '{{name}} должно быть меньше или равно {{maxValue}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть меньше {{maxValue}}',
                self::INCLUSIVE => '{{name}} не дожно быть меньше или равно {{maxValue}}',
            ]
        ];
    }

    public function defaultPlaceholders($maxValue = null, $inclusive = false)
    {
        $this->defaultTemplate = $inclusive ? static::INCLUSIVE : static::STANDARD;
        if ($maxValue instanceof \DateTime) {
            $maxValue = $maxValue->format('Y-m-d H:i:s');
        } elseif ($maxValue instanceof DateTime) {
            $maxValue = $maxValue->format();
        }
        return [
            'name' => 'значение',
            'maxValue' =>  $maxValue
        ];
    }
}