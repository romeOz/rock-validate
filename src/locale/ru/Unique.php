<?php

namespace rock\validate\locale\ru;


class Unique extends \rock\validate\locale\en\Unique
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{value}} уже существует',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{value}} должно существовать',
            ]
        ];
    }
}