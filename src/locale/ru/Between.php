<?php

namespace rock\validate\locale\ru;


use rock\date\DateTime;
use rock\validate\locale\Locale;

/**
 * Class Between
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Between extends Locale
{
    const BOTH = 0;
    const LOWER = 1;
    const GREATER = 2;

    public function defaultTemplates()
    {
        return  [
            self::MODE_DEFAULT => [
                self::BOTH => '{{name}} должно быть между {{minValue}} и {{maxValue}}',
                self::LOWER => '{{name}}  должно быть больше чем {{minValue}}',
                self::GREATER => '{{name}} должно быть меньше чем {{maxValue}}',
            ],
            self::MODE_NEGATIVE => [
                self::BOTH => '{{name}} не должно быть между {{minValue}} и {{maxValue}}',
                self::LOWER => '{{name}}  не должно быть больше {{minValue}}',
                self::GREATER => '{{name}} не должно быть меньше {{maxValue}}',
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
        if ($minValue instanceof DateTime) {
            $minValue = $minValue->format();
        } elseif ($minValue instanceof \DateTime) {
            $minValue = $minValue->format('Y-m-d H:i:s');
        }

        if ($maxValue instanceof DateTime) {
            $maxValue = $maxValue->format();
        } elseif ($maxValue instanceof \DateTime) {
            $maxValue = $maxValue->format('Y-m-d H:i:s');
        }

        return [
            'name' => 'значение',
            'minValue' =>  $minValue,
            'maxValue' => $maxValue
        ];
    }
}