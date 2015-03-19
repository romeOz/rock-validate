<?php

namespace rock\validate\rules;


class Bool extends Rule
{
    public $skipEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_bool($input);
    }
} 