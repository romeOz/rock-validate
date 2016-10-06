<?php

namespace rock\validate\rules;


use Countable;
use rock\validate\ValidateException;

class Length extends Rule
{
    public function __construct($min = null, $max = null, $inclusive = true, $config = [])
    {
        parent::__construct($config);
        if (!is_numeric($min) && !is_null($min)) {
            throw new ValidateException(sprintf('%s is not a valid numeric length', $min));
        }

        if (!is_numeric($max) && !is_null($max)) {
            throw new ValidateException(sprintf('%s is not a valid numeric length', $max));
        }

        if (!is_null($min) && !is_null($max) && $min > $max) {
            throw new ValidateException(sprintf('%s cannot be less than %s for validation', $min, $max));
        }
        $this->params['minValue'] = $min;
        $this->params['maxValue'] = $max;
        $this->params['inclusive'] = $inclusive;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if (is_int($input)) {
            $input = (string)$input;
        }
        $length = $this->extractLength($input);
        return $this->validateMin($length) && $this->validateMax($length);
    }

    protected function extractLength($input)
    {
        if (is_string($input)) {
            return mb_strlen($input, mb_detect_encoding($input));
        } elseif (is_array($input) || $input instanceof Countable) {
            return count($input);
        } elseif (is_object($input)) {
            return count(get_object_vars($input));
        } else {
            return false;
        }
    }

    protected function validateMin($length)
    {
        if (is_null($this->params['minValue'])) {
            return true;
        }
        if ($this->params['inclusive']) {
            return $length >= $this->params['minValue'];
        }
        return $length > $this->params['minValue'];
    }

    protected function validateMax($length)
    {
        if (is_null($this->params['maxValue'])) {
            return true;
        }
        if ($this->params['inclusive']) {
            return $length <= $this->params['maxValue'];
        }
        return $length < $this->params['maxValue'];
    }
} 