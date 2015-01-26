<?php

namespace rock\validate\rules;


class Float extends Rule
{
    public $skipOnEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_float(filter_var($input, FILTER_VALIDATE_FLOAT));
    }
} 