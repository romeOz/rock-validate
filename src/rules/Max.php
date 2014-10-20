<?php

namespace rock\validate\rules;


class Max extends Rule
{
    public function __construct($max, $inclusive = false, $config = [])
    {
        $this->parentConstruct($config);
        $this->params['maxValue'] = $max;
        $this->params['inclusive'] = $inclusive;
    }

    public function validate($input)
    {
        $maxValue = $this->params['maxValue'];
        if ($maxValue instanceof \DateTime && !$input instanceof \DateTime){
            try {
                $input = new \DateTime($input);
            } catch (\Exception $e){
                return false;
            }
        }
        if ($this->params['inclusive']) {
            return $input <= $maxValue;
        } else {
            return $input < $maxValue;
        }
    }
} 