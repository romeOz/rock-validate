<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/***
 * Class Contains
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Contains extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно содержать "{{containsValue}}"',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно содержать "{{containsValue}}"',
            ]
        ];
    }

    public function defaultPlaceholders($containsValue = null)
    {
        return [
            'name' => 'значение',
            'containsValue' => $containsValue
        ];
    }
}