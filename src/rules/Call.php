<?php

namespace rock\validate\rules;

use rock\validate\Exception;

class Call extends Rule
{
    public function __construct($call, $config = [])
    {
        $this->parentConstruct($config);
        if (!is_callable($call)) {
            throw new Exception('Invalid callback.');
        }

        $this->params['callback'] = $call;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return (bool)call_user_func($this->params['callback'], $input);
    }
} 