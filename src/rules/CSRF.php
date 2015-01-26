<?php

namespace rock\validate\rules;


use rock\validate\ValidateException;

class CSRF extends Rule
{

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return $this->getCSRF()->valid($input);
    }

    /**
     * Get CSRF.
     *
     * If exists {@see \rock\di\Container} that uses it.
     *
     * @return \rock\csrf\CSRF
     * @throws \rock\di\ContainerException
     */
    protected function getCSRF()
    {
        if (class_exists('\rock\di\Container')) {
            return \rock\di\Container::load('csrf');
        }

        if (class_exists('\rock\csrf\CSRF')) {
            return new \rock\csrf\CSRF();
        }

        throw new ValidateException(ValidateException::UNKNOWN_CLASS, ['class' => '\rock\csrf\CSRF']);
    }
}