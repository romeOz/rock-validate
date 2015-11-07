<?php

namespace rock\validate;


use rock\base\ObjectInterface;
use rock\base\ObjectTrait;
use rock\helpers\ArrayHelper;
use rock\helpers\Instance;


class Attributes implements ObjectInterface
{
    use ObjectTrait;

    public $attributes = [];
    public $invert = false;
    public $one = false;
    public $remainder = '*';
    protected $errors = [];

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
            if ($attribute === $this->remainder) {
                $this->remainder($validate, $input);
                continue;
            }
            if (!isset($input[$attribute])) {
                $input[$attribute] = null;
            }

            $validate->invert = $this->invert;
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

    protected function remainder(Validate $validate, $input)
    {
        $input = ArrayHelper::diffByKeys($input, array_keys($this->attributes));
        $config = [
            'remainder' => $this->remainder,
            'attributes' => $validate
        ];
        Instance::configure($this, $config);
        $this->validate($input);
    }
}