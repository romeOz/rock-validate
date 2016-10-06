<?php

namespace rock\validate\rules;


class Regex extends Rule
{
    public function __construct($regex = null, $config = [])
    {
        parent::__construct($config);
        $this->params['regex'] = $regex;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return (bool)preg_match($this->params['regex'], $input);
    }
} 