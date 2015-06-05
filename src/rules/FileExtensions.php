<?php

namespace rock\validate\rules;


use rock\file\UploadedFile;
use rock\validate\ValidateException;

class FileExtensions extends Rule
{
    public function __construct($extensions, $checkExtensionByMimeType = true, $config = [])
    {
        parent::__construct($config);
        $this->params['extensions'] = $this->toArray($extensions);
        $this->params['checkExtensionByMimeType'] = $checkExtensionByMimeType;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        if ($input instanceof UploadedFile) {
            if ($input->error !== UPLOAD_ERR_OK) {
                $this->params['extensions'] = $this->toString($this->params['extensions']);
                return false;
            }
            $extension = mb_strtolower($input->extension, 'utf-8');
            $input =  $input->tempName;
        } elseif(is_string($input)) {
            if (!$extension = strtolower(pathinfo($input, PATHINFO_EXTENSION))) {
                $this->params['extensions'] = $this->toString($this->params['extensions']);
                return false;
            }
            //$extension = $extension['extension'];
        } else {
            throw new ValidateException(ValidateException::UNKNOWN_VAR, ['name'=> 'input']);
        }

        if ($this->params['checkExtensionByMimeType']) {
            $mimeType = \rock\helpers\FileHelper::getMimeType($input);
            if ($mimeType === null) {
                $this->params['extensions'] = $this->toString($this->params['extensions']);
                return false;
            }
            $extensionsByMimeType = \rock\helpers\FileHelper::getExtensionsByMimeType($mimeType);
            if (!in_array($extension, $extensionsByMimeType, true)) {
                $this->params['extensions'] = $this->toString($this->params['extensions']);
                return false;
            }
        }
        if (!in_array($extension, $this->toArray($this->params['extensions']), true)) {
            $this->params['extensions'] = $this->toString($this->params['extensions']);
            return false;
        }

        return true;
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