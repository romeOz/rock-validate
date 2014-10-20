<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Equals extends Locale
{
    const EQUALS = 0;
    const IDENTICAL = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::EQUALS => '{{name}} must be equals {{compareTo}}',
                self::IDENTICAL => '{{name}} must be identical as {{compareTo}}',
            ],
            self::MODE_NEGATIVE => array(
                self::EQUALS => '{{name}} must not be equals {{compareTo}}',
                self::IDENTICAL => '{{name}} must not be identical as {{compareTo}}',
            )
        ];
    }

    public function defaultPlaceholders($compareTo = null, $compareIdentical = false)
    {
        $this->defaultTemplate = $compareIdentical ? self::IDENTICAL : self::EQUALS;
        return ['name' => 'value'];
    }
}