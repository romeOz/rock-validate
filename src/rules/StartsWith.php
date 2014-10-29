<?php

namespace rock\validate\rules;

class StartsWith extends Rule
{
    public function __construct($startValue, $identical = false, $config = [])
    {
        $this->parentConstruct($config);
        $this->params['startValue'] = $startValue;
        $this->params['identical'] = $identical;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if ($this->params['identical'] ) {
            return $this->validateIdentical($input);
        }
        return $this->validateEquals($input);
    }

    protected function validateEquals($input)
    {
        if (is_array($input)) {
            return reset($input) == $this->params['startValue'];
        }
        return \rock\helpers\String::startsWith($input, $this->params['startValue'], false);
    }

    protected function validateIdentical($input)
    {
        if (is_array($input)) {
            return reset($input) === $this->params['startValue'];
        }
        return \rock\helpers\String::startsWith($input, $this->params['startValue'], true);
    }
}