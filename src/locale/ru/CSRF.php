<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class CSRF
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class CSRF extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'CSRF-токен должен быть верным',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => 'CSRF-токен не должен быть верным',
            )
        ];
    }
}