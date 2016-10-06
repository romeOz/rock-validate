<?php

namespace rock\validate\rules;


class Odd extends Rule
{
    public function validate($input)
    {
        return (int)$input % 2 !== 0;
    }
} 