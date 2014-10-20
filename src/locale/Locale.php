<?php

namespace rock\validate\locale;


use rock\validate\ClassName;

abstract class Locale
{
    use ClassName;

    const STANDARD = 0;
    const NAMED = 1;
    const MODE_DEFAULT = 1;
    const MODE_NEGATIVE = 0;

    public $defaultTemplate = self::STANDARD;

    abstract public function defaultTemplates();

    public function defaultPlaceholders()
    {
        return ['name' => 'value'];
    }
}