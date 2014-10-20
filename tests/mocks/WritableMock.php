<?php

namespace rockunit\mocks;


use rock\validate\rules\Writable;

class WritableMock extends Writable
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            return $input->isWritable();
        }
        return is_string($input) && $GLOBALS['is_writable'];
    }
} 