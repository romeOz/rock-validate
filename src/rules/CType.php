<?php

namespace rock\validate\rules;


use rock\validate\ValidateException;

abstract class CType extends Rule
{
    public $skipEmpty = false;

    public function __construct($additionalChars = '', $config = [])
    {
        $this->parentConstruct($config);
        if (!is_string($additionalChars)) {
            throw new ValidateException('Invalid list of additional characters to be loaded');
        }
        $this->params['additionalChars'] = $additionalChars;
    }

    protected function filterWhiteSpace($input)
    {
        if (!empty($this->params['additionalChars'])) {
            $input = str_replace(str_split($this->params['additionalChars']), '', $input);
        }
        return preg_replace('/\s/', '', $input);
    }
}