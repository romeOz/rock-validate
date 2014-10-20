<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/**
 * Class Ip
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Ip extends Locale
{
    const STANDARD = 0;
    const NETWORK_RANGE = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть IP-адрессом',
                self::NETWORK_RANGE => '{{name}} должно быть IP-адрессом в диапазоне {{range}}',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть IP-адрессом',
                self::NETWORK_RANGE => '{{name}} не должно быть IP-адрессом в диапазоне {{range}}',
            ]
        ];
    }

    public function defaultPlaceholders(array $networkRange = null)
    {
        $message = '';
        if ($networkRange) {
            $range = $networkRange;
            $message = $range['min'];
            $message .= isset($range['max']) ? '-' . $range['max'] : '/' . long2ip($range['mask']);
        }
        return [
            'name' => 'значение',
            'range' =>  $message
        ];
    }
}