<?php

namespace rock\validate\rules;


class String extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_string($input);
    }
} 