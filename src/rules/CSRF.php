<?php

namespace rock\validate\rules;


use rock\validate\ValidateException;

class CSRF extends Rule
{
    /** @var string|array|\rock\csrf\CSRF  */
    public $csrf = 'csrf';

    public function init()
    {
        if (!is_object($this->csrf)) {
            if (class_exists('\rock\di\Container')) {
                $this->csrf = \rock\di\Container::load($this->csrf);
                return;
            }
            throw new ValidateException(ValidateException::NOT_INSTALL_CSRF);
        }
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return $this->csrf->valid($input);
    }
}