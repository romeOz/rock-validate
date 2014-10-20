<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Alpha
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Alpha extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно содержать только буквы',
                self::EXTRA => '{{name}} должно содержать только буквы и "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно содержать буквы',
                self::EXTRA => '{{name}} не должно содержать буквы или "{{additionalChars}}"'
            )
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'значение', 'additionalChars' => $additionalChars];
    }
}