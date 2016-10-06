<?php

namespace rock\validate\rules;

class NoWhitespace extends Rule
{
    public function validate($input)
    {
        return is_null($input) || !preg_match('#\s#', $input);
    }
} 