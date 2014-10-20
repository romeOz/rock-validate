<?php

namespace rock\validate\rules;


use rock\validate\Exception;

class Between extends Rule
{
    public function __construct($min = null, $max = null, $inclusive = false, $config = [])
    {
        if (!is_null($min) && !is_null($max) && $min > $max) {
            throw new Exception(sprintf('%s cannot be less than  %s for validation', $min, $max));
        }
        $this->parentConstruct($config);
        $this->params['minValue'] = $min;
        $this->params['maxValue'] = $max;
        $this->params['inclusive'] = $inclusive;
    }

    public function validate($input)
    {

        if (!is_null($this->params['minValue'])) {
            if (!(new Min($this->params['minValue'], $this->params['inclusive']))->validate($input)) {
                return false;
            }
        }
        if (!is_null($this->params['maxValue'])) {
            if (!(new Max($this->params['maxValue'], $this->params['inclusive']))->validate($input)) {
                return false;
            }
        }
        return true;
    }
} 