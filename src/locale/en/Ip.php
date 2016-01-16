<?php

namespace rock\validate\locale\en;


use rock\validate\locale\Locale;

class Ip extends Locale
{
    const STANDARD = 0;
    const NETWORK_RANGE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} must be an IP address',
                self::NETWORK_RANGE => '{{name}} must be an IP address in the {{range}} range',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} must not be an IP address',
                self::NETWORK_RANGE => '{{name}} must not be an IP address in the {{range}} range',
            ]
        ];
    }

    public function defaultPlaceholders(array $range = null)
    {
        $message = '';
        if (!empty($range)) {
            $message = $range['min'];
            $message .= isset($range['max']) ? '-' . $range['max'] : '/' . long2ip($range['mask']);
        }
        $this->defaultTemplate = !empty($message) ? self::NETWORK_RANGE : self::STANDARD;
        return [
            'name' => 'value',
            'range' =>  $message
        ];
    }
}