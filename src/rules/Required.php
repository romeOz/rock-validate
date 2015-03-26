<?php

namespace rock\validate\rules;


class Required extends Rule
{
    public $skipEmpty = false;

    public function __construct($strict = true, $config = [])
    {
        $this->parentConstruct($config);
        $this->params['strict'] = $strict;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if (is_string($input)) {
            $input = trim($input);
        }

        if ($this->params['strict']) {
            return !empty($input);
        }

        return $input !== '' && $input !== null;
    }
} 