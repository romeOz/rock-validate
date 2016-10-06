<?php

namespace rock\validate\rules;


use rock\helpers\Instance;

class CSRF extends Rule
{
    /** @var string|array|\rock\csrf\CSRF  */
    public $csrf = 'csrf';

    public function init()
    {
        $this->csrf = Instance::ensure($this->csrf, '\rock\csrf\CSRF');
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return $this->csrf->check($input);
    }
}