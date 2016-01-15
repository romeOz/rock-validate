<?php

namespace rock\validate\rules;


/**
 * Class File
 *
 * @codeCoverageIgnore
 * @package rock\validate\rules
 */
class File extends Rule
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            return $input->isFile();
        }
        return is_string($input) && is_file($input);
    }
} 