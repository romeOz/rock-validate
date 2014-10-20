<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Equals
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Equals extends Locale
{
    const EQUALS = 0;
    const IDENTICAL = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::EQUALS => '{{name}} должно быть равным {{compareTo}}',
                self::IDENTICAL => '{{name}} должно быть идентично {{compareTo}}',
            ],
            self::MODE_NEGATIVE => array(
                self::EQUALS => '{{name}} не должно быть равным {{compareTo}}',
                self::IDENTICAL => '{{name}} не должно быть идентично {{compareTo}}',
            )
        ];
    }

    public function defaultPlaceholders($compareTo = null, $compareIdentical = false)
    {
        $this->defaultTemplate = $compareIdentical ? self::IDENTICAL : self::EQUALS;
        return ['name' => 'значение'];
    }
}