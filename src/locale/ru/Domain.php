<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Domain
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Domain extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должен быть верным',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должен быть верным',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'домен'];
    }
}