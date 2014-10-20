<?php

namespace rock\validate\rules;


class Contains extends Rule
{
    public function __construct($containsValue, $identical = false, $config = [])
    {
        $this->parentConstruct($config);
        $this->params['containsValue'] = $containsValue;
        $this->params['identical'] = $identical;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if ($this->params['identical']) {
            return $this->validateIdentical($input);
        }
        return $this->validateEquals($input);
    }

    protected function validateEquals($input)
    {
        if (is_array($input)) {
            return in_array($this->params['containsValue'], $input);
        }
        return false !== mb_stripos($input, $this->params['containsValue'], 0, mb_detect_encoding($input));
    }

    protected function validateIdentical($input)
    {
        if (is_array($input)) {
            return in_array($this->params['containsValue'], $input, true);
        }
        return false !== mb_strpos($input, $this->params['containsValue'], 0, mb_detect_encoding($input));
    }
}