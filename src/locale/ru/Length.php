<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Length
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Length extends Locale
{
    const BOTH = 0;
    const LOWER = 1;
    const GREATER = 2;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::BOTH => '{{name}} должно иметь длину в диапазоне от {{minValue}} до {{maxValue}}',
                self::LOWER => '{{name}} должно иметь длину больше {{minValue}}',
                self::GREATER => '{{name}} должно иметь длину меньше {{maxValue}}',
            ],
            self::MODE_NEGATIVE => array(
                self::BOTH => '{{name}} не должно иметь длину в диапазоне от {{minValue}} до {{maxValue}}',
                self::LOWER => '{{name}} не должно иметь длину больше {{minValue}}',
                self::GREATER => '{{name}} не должно иметь длину меньше {{maxValue}}',
            )
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
            'name' => 'значение',
            'minValue' =>  $minValue,
            'maxValue' => $maxValue
        ];
    }
}