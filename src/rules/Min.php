<?php

namespace rock\validate\rules;


use ArrayAccess;
use Countable;
use Traversable;

class Min extends Rule
{
    public function __construct($min, $inclusive = false, $config = [])
    {
        parent::__construct($config);
        $this->params['minValue'] = $min;
        $this->params['inclusive'] = $inclusive;
    }

    public function validate($input)
    {
        $minValue = $this->params['minValue'];
        if ($minValue instanceof \DateTime && !$input instanceof \DateTime){
            try {
                $input = new \DateTime($input);
            } catch (\Exception $e){
                return false;
            }
        }

        if ($this->params['inclusive']) {
            return $input >= $minValue;
        } else {
            return $input > $minValue;
        }
    }
} 