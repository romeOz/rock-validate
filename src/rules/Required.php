<?php

namespace rock\validate\rules;


class Required extends Rule
{
    public $skipOnEmpty = false;
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if (is_string($input)) {
            $input = trim($input);
        }

        return !empty($input);
    }
} 