<?php

namespace rock\validate\rules;

use rock\validate\ValidateException;

class Call extends Rule
{
    protected $call;
    protected $args = [];
    public function __construct($call, array $args = null, $config = [])
    {
        $this->parentConstruct($config);
        if (!is_callable($call)) {
            throw new ValidateException('Invalid callback.');
        }
        $this->call = $call;
        if (!empty($args)) {
            $this->args = $args;
        }
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {

        $args = $this->args;
        array_unshift($args, $input);

        return (bool)call_user_func_array($this->call, $args);
    }
} 