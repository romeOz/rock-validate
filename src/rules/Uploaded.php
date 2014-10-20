<?php

namespace rock\validate\rules;

/**
 * Class Uploaded
 *
 * @codeCoverageIgnore
 * @package rock\validate\rules
 */
class Uploaded extends Rule
{
    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if ($input instanceof \SplFileInfo) {
            $input = $input->getPathname();
        }

        return is_string($input) && is_uploaded_file($input);
    }
} 