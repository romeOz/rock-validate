<?php

namespace rock\validate\rules;


use ArrayAccess;
use Countable;
use Traversable;

class Domain extends Rule
{
    public function validate($input)
    {
        return (bool)preg_match('/^[a-zа-яё\\d][\\w-\.]{1,61}[a-zа-яё\\d]\.[a-zа-яё]{2,}$/iu', $input);
    }
} 