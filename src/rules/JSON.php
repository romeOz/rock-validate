<?php

namespace rock\validate\rules;


class JSON extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return (bool)json_decode($input);
    }
} 