<?php

namespace rock\validate\rules;

class EndsWith extends Rule
{
    public function __construct($endValue, $identical = false, $config = [])
    {
        $this->parentConstruct($config);
        $this->params['endValue'] = $endValue;
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
            return end($input) == $this->params['endValue'];
        }
        return \rock\helpers\StringHelper::endsWith($input, $this->params['endValue'], false);
    }

    protected function validateIdentical($input)
    {
        if (is_array($input)) {
            return end($input) === $this->params['endValue'];
        }
        return \rock\helpers\StringHelper::endsWith($input, $this->params['endValue'], true);
    }
}