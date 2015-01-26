<?php

namespace rock\validate\rules;


use ArrayAccess;
use Countable;
use Traversable;

class NoWhitespace extends Rule
{
    public function validate($input)
    {
        return is_null($input) || !preg_match('#\s#', $input);
    }
} 