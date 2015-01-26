<?php

namespace rock\validate\rules;


use rock\base\ObjectInterface;
use rock\base\ObjectTrait;

abstract class Rule implements ObjectInterface
{
    use ObjectTrait{
        ObjectTrait::__construct as parentConstruct;
    }

    public $params = [];
    /**
     * @var callable a PHP callable that replaces the default implementation of {@see \rock\validate\Validate::isEmpty()}.
     * If not set, {@see \rock\validate\Validate::isEmpty()} will be used to check if a value is empty. The signature
     * of the callable should be `function ($value)` which returns a boolean indicating
     * whether the value is empty.
     */
    public $isEmpty;
    /**
     * @var boolean whether this validation rule should be skipped if the attribute value
     * is null or an empty string.
     */
    public $skipOnEmpty = true;

    /**
     * @param mixed $input
     * @return bool
     */
    abstract public function validate($input);
}