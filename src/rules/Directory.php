<?php

namespace rock\validate\rules;


class Directory extends Rule
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            return $input->isDir();
        }
        return is_string($input) && is_dir($input);
    }
} 