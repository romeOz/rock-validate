<?php

namespace rock\validate\rules;


use rock\validate\ValidateException;

class FileSizeBetween extends Rule
{
    public function __construct($min = null, $max = null, $inclusive = false, $config = [])
    {
        $this->parentConstruct($config);
        if (!is_null($min) && !is_null($max) && $min > $max) {
            throw new ValidateException(sprintf('%s cannot be less than  %s for validation', $min, $max));
        }
        $this->params['minValue'] = \rock\helpers\FileHelper::sizeToBytes($min);;
        $this->params['maxValue'] = \rock\helpers\FileHelper::sizeToBytes($max);
        $this->params['inclusive'] = $inclusive;
    }

    public function validate($input)
    {

        if (!is_null($this->params['minValue'])) {
            if (!(new FileSizeMin($this->params['minValue'], $this->params['inclusive']))->validate($input)) {
                return false;
            }
        }
        if (!is_null($this->params['maxValue'])) {
            if (!(new FileSizeMax($this->params['maxValue'], $this->params['inclusive']))->validate($input)) {
                return false;
            }
        }
        return true;
    }
}