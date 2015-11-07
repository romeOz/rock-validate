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
    public $invert = false;
    protected $errors = [];

    public function __construct($config = [])
    {
        $this->parentConstruct($config);
    }

    public function validate($value)
    {
        $this->if->invert = $this->then->invert = $this->invert;
        if ($this->if->validate($value)) {
            if (!$this->then->validate($value)) {
                $this->errors = $this->then->getErrors();
                return false;
            }
            return true;
        }

        if (!isset($this->else)) {
            return $this->invert;
        }

        $this->else->invert = $this->invert;
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