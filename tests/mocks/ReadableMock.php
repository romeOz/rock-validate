<?php

namespace rockunit\mocks;


use rock\validate\rules\Readable;

class ReadableMock extends Readable
{
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            return $input->isReadable();
        }
        return is_string($input) && $GLOBALS['is_readable'];
    }
} 