<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Cntrl
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Cntrl extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно содержать только управляющие символы',
                self::EXTRA => '{{name}} должно содержать только управляющие символы и "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно содержать управляющих символов',
                self::EXTRA => '{{name}} не должно содержать управляющих символов или "{{additionalChars}}"'
            )
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'значение', 'additionalChars' => $additionalChars];
    }
}