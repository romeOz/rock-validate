<?php

namespace rock\validate;

use rock\base\ObjectInterface;
use rock\base\ObjectTrait;

class When implements ObjectInterface
{
    use ObjectTrait {
        ObjectTrait::__construct as parentConstruct;
    }

    /** @var  Validate */
    public $if;
    /** @var  Validate */
    public $then;
    /** @var  Validate|null */
    public $else;
    public $valid = true;
    protected $errors = [];

    public function __construct($config = [])
    {
        $this->parentConstruct($config);
    }

    public function validate($value)
    {
        $this->if->valid = $this->then->valid = $this->valid;
        if ($this->if->validate($value)) {
            if (!$this->then->validate($value)) {
                $this->errors = $this->then->getErrors();
                return false;
            }
            return true;
        }

        if (!isset($this->else)) {
            return $this->valid;
        }

        $this->else->valid = $this->valid;
        if (!$this->else->validate($value)) {
            $this->errors = $this->else->getErrors();
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}