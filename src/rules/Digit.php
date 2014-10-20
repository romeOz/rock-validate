<?php

namespace rock\validate\rules;

class Digit extends CType
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if (!is_scalar($input)) {
            return false;
        }
        $input = $this->filterWhiteSpace((string)$input);
        return $input === '' || ctype_digit($input);
    }
}