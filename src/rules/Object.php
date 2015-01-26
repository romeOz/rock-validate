<?php

namespace rock\validate\rules;


class Object extends Rule
{
    public $skipOnEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_object($input);
    }
} 