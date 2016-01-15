<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Digit
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Digit extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно содержать только цифры',
                self::EXTRA => '{{name}} должно содержать только цифры или "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно содержать только цифры',
                self::EXTRA => '{{name}} не должно содержать только цифры или "{{additionalChars}}"'
            ]
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'значение', 'additionalChars' => $additionalChars];
    }
}