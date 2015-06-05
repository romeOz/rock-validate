<?php

namespace rock\validate\rules;

class Equals extends Rule
{
    public function __construct($compareTo, $compareIdentical = false, $config = [])
    {
        parent::__construct($config);
        $this->params['compareTo'] = $compareTo;
        $this->params['compareIdentical'] = $compareIdentical;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if ($this->params['compareIdentical']) {
            return $input === $this->params['compareTo'];
        } else {
            return $input == $this->params['compareTo'];
        }
    }
} 