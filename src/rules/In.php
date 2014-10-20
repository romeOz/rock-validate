<?php

namespace rock\validate\rules;

class In extends Rule
{
    public function __construct($haystack, $compareIdentical = false, $config = [])
    {
        $this->parentConstruct($config);
        $this->params['haystack'] = $haystack;
        $this->params['compareIdentical'] = $compareIdentical;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if (is_array($this->params['haystack'])) {
            return in_array($input, $this->params['haystack'], $this->params['compareIdentical']);
        }
        if (!is_string($this->params['haystack'])) {
            return false;
        }
        $enc = mb_detect_encoding($input);

        if ($this->params['compareIdentical']) {
            return mb_strpos($this->params['haystack'], $input, 0, $enc) !== false;
        }
        return mb_stripos($this->params['haystack'], $input, 0, $enc) !== false;
    }
} 