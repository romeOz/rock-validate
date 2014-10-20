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
        return 0 === mb_stripos($input, $this->params['startValue'], 0, mb_detect_encoding($input));
    }

    protected function validateIdentical($input)
    {
        if (is_array($input)) {
            return reset($input) === $this->params['startValue'];
        }
        return 0 === mb_strpos($input, $this->params['startValue'], 0, mb_detect_encoding($input));
    }
}