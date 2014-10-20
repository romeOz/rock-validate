<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

class Required extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} не должно быть пустым',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} должно быть пустым',
            ]
        ];
    }

    public function defaultPlaceholders()
    {
        return [
            'name' => 'значение'
        ];
    }
}