<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class EndsWith
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class EndsWith extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно заканчиваться на "{{endValue}}"',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно заканчиваться на "{{endValue}}"',
            ]
        ];
    }

    public function defaultPlaceholders($endValue = null)
    {
        return [
            'name' => 'значение',
            'endValue' => $endValue
        ];
    }
}