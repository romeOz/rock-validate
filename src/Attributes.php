<?php

namespace rock\validate;


use rock\base\ObjectInterface;
use rock\base\ObjectTrait;


class Attributes implements ObjectInterface
{
    use ObjectTrait {
        ObjectTrait::__construct as parentConstruct;
    }

    public $attributes = [];
    public $valid = true;
    public $one = false;
    protected $errors = [];

    public function __construct($config = [])
    {
        $this->parentConstruct($config);
    }

    public function validate($input)
    {
        if (is_object($input)) {
            $input = (array)$input;
        }
        if ($this->attributes instanceof Validate) {
            $this->each($input);
        }
        foreach ($this->attributes as $attribute => $validate) {
            if (!$validate instanceof Validate) {
                throw new ValidateException("`{$attribute}` is not `".Validate::className()."`");
            }
            if (!isset($input[$attribute])) {
                $input[$attribute] = null;
            }

            $validate->valid = $this->valid;
            if ($validate->validate($input[$attribute])) {
                continue;
            }

            if ($errors = $validate->getErrors()) {
                $this->errors[$attribute] = $errors;
                if ($this->one) {
                    break;
                }
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function each($input)
    {
        $validate = $this->attributes;
        $this->attributes = [];
        foreach($input as $key => $value) {
            $this->attributes[$key] = $validate;
        }
    }
}