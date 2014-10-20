<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Directory
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Directory extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть директорией',
            ],
            self::MODE_NEGATIVE => array(
                self::STANDARD => '{{name}} не должно быть директорией',
            )
        ];
    }

    public function defaultPlaceholders()
    {
        return ['name' => 'значение'];
    }
}