<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class JSON
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class JSON extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть JSON-представлением',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть JSON-представлением',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}