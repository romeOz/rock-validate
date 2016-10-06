<?php

namespace rock\validate\rules;


class StringRule extends Rule
{
    public $skipEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_string($input);
    }
} 