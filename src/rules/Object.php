<?php

namespace rock\validate\rules;


class Object extends Rule
{
    public $skipEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_object($input);
    }
} 