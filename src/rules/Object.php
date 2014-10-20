<?php

namespace rock\validate\rules;


class Object extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_object($input);
    }
} 