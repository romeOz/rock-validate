<?php

namespace rock\validate\rules;

/**
 * Class FileExists
 *
 * @codeCoverageIgnore
 * @package rock\validate\rules
 */
class FileExists extends Rule
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            $input = $input->getPathname();
        }
        return (is_string($input) && file_exists($input));
    }
} 