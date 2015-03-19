<?php

namespace rock\validate\rules;


use ArrayAccess;
use Countable;
use Traversable;

class Arr extends Rule
{
    public $skipEmpty = false;
    public function validate($input)
    {
        return is_array($input) || ($input instanceof ArrayAccess
                                    && $input instanceof Traversable
                                    && $input instanceof Countable);
    }
} 