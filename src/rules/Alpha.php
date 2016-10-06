<?php

namespace rock\validate\rules;

class Alpha extends CType
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if (!is_scalar($input) || $input === '') {
            return false;
        }
        $input = $this->filterWhiteSpace((string)$input);
        return $input === '' || ctype_alpha($input);
    }
}