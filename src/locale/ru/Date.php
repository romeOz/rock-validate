<?php

namespace rock\validate\locale\ru;


use rock\validate\locale\Locale;

/***
 * Class Date
 *
 * @codeCoverageIgnore
 * @package rock\validate\locale\ru
 */
class Date extends Locale
{
    const FORMAT = 1;

    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => '{{name}} должно быть датой',
                self::FORMAT => '{{name}} должно соответствовать фомату: {{format}}'
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => '{{name}} не должно быть датой',
                self::FORMAT => '{{name}} не должно соответствовать фомату: {{format}}'
            ]
        ];
    }

    public function defaultPlaceholders($format = null)
    {
        if (empty($format)) {
            return [
                'name' => 'значение',
            ];
        }

        return [
            'name' => 'значение',
            'format' =>  date($format, strtotime('2005-12-30 01:02:03'))
        ];
    }
}