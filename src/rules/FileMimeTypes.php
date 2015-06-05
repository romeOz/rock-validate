<?php

namespace rock\validate\rules;

use rock\file\UploadedFile;

class FileMimeTypes extends Rule
{
    public function __construct($mimeTypes, $config = [])
    {
        parent::__construct($config);
        $this->params['mimeTypes'] = $this->toArray($mimeTypes);
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if ($input instanceof UploadedFile) {
            if ($input->error !== UPLOAD_ERR_OK) {
                $this->params['mimeTypes'] = $this->toString($this->params['mimeTypes']);
                return false;
            }
            $input =  $input->tempName;
        }
        if (in_array(\rock\helpers\FileHelper::getMimeType($input), $this->toArray($this->params['mimeTypes']), true)) {
            return true;
        }
        if (is_array($this->params['mimeTypes'])) {
            $this->params['mimeTypes'] = $this->toString($this->params['mimeTypes']);
        }
        return false;
    }

    protected function toArray($value)
    {
        if (!is_array($value)) {
            return preg_split('/[\s,]+/', strtolower($value), -1, PREG_SPLIT_NO_EMPTY);
        }
        return $value;
    }

    protected function toString($value)
    {
        if (is_array($value)) {
            return implode(', ', $value);
        }
        return $value;
    }
}