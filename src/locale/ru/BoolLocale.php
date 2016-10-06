<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Bool
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class BoolLocale extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть булевым',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть булевым',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}