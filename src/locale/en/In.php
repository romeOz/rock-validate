<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class In extends Locale
{
    const FORMAT = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be in: {{haystack}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be in: {{haystack}}',
            ]
        ];
    }

    public function defaultPlaceholders($haystack = null)
    {
        return [
            'name' => 'value',
            'haystack' => is_array($haystack) ? implode(', ', $haystack) : $haystack
        ];
    }
}