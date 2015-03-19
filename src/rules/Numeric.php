<?php

namespace rock\validate\rules;


class Numeric extends Rule
{
    public $skipEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_numeric($input);
    }
} 