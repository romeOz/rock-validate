<?php

namespace rock\validate\rules;


class Lowercase extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return $input === mb_strtolower($input, mb_detect_encoding($input));
    }
} 