<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class In
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class In extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно совпадать с: {{haystack}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно совпадать с: {{haystack}}',
            ]
        ];
    }

    public function defaultPlaceholders($haystack = null)
    {
        return [
            'name' => 'значение',
            'haystack' => is_array($haystack) ? implode(', ', $haystack) : $haystack
        ];
    }
}