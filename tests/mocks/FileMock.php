<?php

namespace rockunit\mocks;


use rock\validate\rules\File;

class FileMock extends File
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            return $input->isFile();
        }
        return is_string($input) && $GLOBALS['is_file'];
    }
} 