<?php

namespace rock\validate\rules;


class Required extends Rule
{
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