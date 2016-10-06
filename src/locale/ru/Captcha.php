<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Captcha
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Captcha extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'каптча должна быть верной',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'каптча не должна быть верной',
            ]
        ];
    }
}