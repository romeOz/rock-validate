<?php

namespace rock\validate\rules;

/**
 * Class Exists
 *
 * @codeCoverageIgnore
 * @package rock\validate\rules
 */
class Exists extends Rule
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            $input = $input->getPathname();
        }
        return (is_string($input) && file_exists($input));
    }
} 