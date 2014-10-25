<?php

namespace rock\validate\rules;


class Closure extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_callable($input);
    }
} 