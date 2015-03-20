<?php

namespace rock\validate\rules;

class Call extends Rule
{
    protected $call;
    protected $args = [];
    public function __construct(callable $call, array $args = null, $config = [])
    {
        $this->parentConstruct($config);
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