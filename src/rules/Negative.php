<?php

namespace rock\validate\rules;


class Negative extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return $input < 0;
    }
} 