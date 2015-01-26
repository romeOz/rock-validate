<?php

namespace rock\validate\rules;


class String extends Rule
{
    public $skipOnEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_string($input);
    }
} 