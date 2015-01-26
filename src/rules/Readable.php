<?php

namespace rock\validate\rules;


use ArrayAccess;
use Countable;
use Traversable;

/**
 * Class Readable
 *
 * @codeCoverageIgnore
 * @package rock\validate\rules
 */
class Readable extends Rule
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            return $input->isReadable();
        }
        return (is_string($input) && is_readable($input));
    }
}