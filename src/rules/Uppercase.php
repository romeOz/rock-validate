<?php

namespace rock\validate\rules;


class Uppercase extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return $input === mb_strtoupper($input, mb_detect_encoding($input));
    }
} 