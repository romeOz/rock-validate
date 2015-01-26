<?php

namespace rock\validate\rules;


use ArrayAccess;
use Countable;
use Traversable;

class Odd extends Rule
{
    public function validate($input)
    {
        return (int)$input % 2 !== 0;
    }
} 