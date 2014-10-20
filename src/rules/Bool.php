<?php

namespace rock\validate\rules;


class Bool extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_bool($input);
    }
} 