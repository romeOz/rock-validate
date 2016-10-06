<?php

namespace rockunit\mocks;


use rock\validate\rules\Exists;

class ExistsMock extends Exists
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            $input = $input->getPathname();
        }
        return is_string($input) && $GLOBALS['file_exists'];
    }
} 