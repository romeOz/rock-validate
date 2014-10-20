<?php

namespace rock\validate\rules;


class Numeric extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_numeric($input);
    }
} 