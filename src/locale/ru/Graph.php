<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Graph
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Graph extends Locale
{
    const EXTRA = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно содержать все символы, кроме пробелов',
                self::EXTRA => '{{name}} должно содержать все символы, кроме пробелов и "{{additionalChars}}"'
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} должно содержать только пробелы',
                self::EXTRA => '{{name}} должно содержать только пробелы или "{{additionalChars}}"'
            )
        ];
    }

    public function defaultPlaceholders($additionalChars = '')
    {
        $this->defaultTemplate = $additionalChars ? self::EXTRA : self::STANDARD;
        return ['name' => 'значение', 'additionalChars' => $additionalChars];
    }
}