<?php

namespace rock\validate\rules;


class Positive extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return $input > 0;
    }
} 