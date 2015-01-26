<?php

namespace rock\validate\rules;


class Closure extends Rule
{
    public $skipOnEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_callable($input);
    }
} 