<?php

namespace rock\validate\rules;


class Email extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return is_string($input) && preg_match(
            '/^(\\w+[\\w\.\+\-]+)?\\w+@(\\w+\.)+\\w+$/iu',
            $input
        );
    }
} 