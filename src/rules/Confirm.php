<?php

namespace rock\validate\rules;

class Confirm extends Equals
{
    public function __construct($compareTo, $compareIdentical = true, $config = [])
    {
        parent::__construct($compareTo, true, $config);
    }
} 