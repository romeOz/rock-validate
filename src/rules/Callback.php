<?php

namespace rock\validate\rules;

use rock\validate\Exception;

class Callback extends Rule
{
    public function __construct($callback, $config = [])
    {
        $this->parentConstruct($config);
        if (!is_callable($callback)) {
            throw new Exception('Invalid callback.');
        }

        $this->params['callback'] = $callback;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return (bool)call_user_func($this->params['callback'], $input);
    }
} 