<?php

namespace rock\validate\rules;

/**
 * Class Writable
 *
 * @codeCoverageIgnore
 * @package rock\validate\rules
 */
class Writable extends Rule
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            return $input->isWritable();
        }

        return (is_string($input) && is_writable($input));
    }
}