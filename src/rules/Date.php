<?php

namespace rock\validate\rules;

use DateTime;

class Date extends Rule
{
    public function __construct($format = null, $config = [])
    {
        parent::__construct($config);
        $this->params['format'] = $format;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if ($input instanceof DateTime) {
            return true;
        } elseif (!is_string($input)) {
            return false;
        } elseif (is_null($this->params['format'])) {
            return false !== strtotime($input);
        }
        $dateFromFormat = DateTime::createFromFormat($this->params['format'], $input);

        if (DateTime::getLastErrors()['warning_count'] > 0) {
            return false;
        }
        return $dateFromFormat
               && $input === date($this->params['format'], $dateFromFormat->getTimestamp());
    }
} 