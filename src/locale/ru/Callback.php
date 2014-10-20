<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Callback
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Callback extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть верным',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть верным',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}