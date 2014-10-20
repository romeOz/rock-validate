<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Space
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Space extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно содержать только пробельные символы',
                self::EXTRA => '{{name}} должно содержать только пробельные символы и "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно содержать пробельные символы',
                self::EXTRA => '{{name}} не должно содержать пробельные символы и "{{additionalChars}}"'
            )
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'значение', 'additionalChars' => $additionalChars];
    }
}