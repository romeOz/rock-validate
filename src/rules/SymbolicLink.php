<?php

namespace rock\validate\rules;

/**
 * Class SymbolicLink
 *
 * @codeCoverageIgnore
 * @package rock\validate\rules
 */
class SymbolicLink extends Rule
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            return $input->isLink();
        }

        return (is_string($input) && is_link($input));
    }
}