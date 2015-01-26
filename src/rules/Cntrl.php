<?php

namespace rock\validate\rules;

class Cntrl extends CType
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if (!is_scalar($input) || $input === '') {
            return false;
        }
        $input = str_replace(str_split($this->params['additionalChars']), '', (string)$input);
        return $input === '' || ctype_cntrl($input);
    }
}