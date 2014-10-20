<?php

namespace rockunit\mocks;


use rock\validate\rules\FileExists;

class FileExistsMock extends FileExists
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            $input = $input->getPathname();
        }
        return is_string($input) && $GLOBALS['file_exists'];
    }
} 