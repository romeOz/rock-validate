<?php

namespace rock\validate\rules;


class NullValue extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_null($input);
    }
} 