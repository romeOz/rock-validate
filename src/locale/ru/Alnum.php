<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Alnum
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Alnum extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно содержать только буквы или цифры',
                self::EXTRA => '{{name}} должно содержать только буквы, цифры и "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно содержать буквы и цифры',
                self::EXTRA => '{{name}} не должно содержать буквы, цифры или "{{additionalChars}}"'
            )
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'значение', 'additionalChars' => $additionalChars];
    }
}