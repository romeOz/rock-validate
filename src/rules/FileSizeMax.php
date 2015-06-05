<?php

namespace rock\validate\rules;

use rock\file\UploadedFile;
use rock\helpers\FileHelper;

class FileSizeMax extends Rule
{
    public function __construct($maxValue = null, $inclusive = false, $config = [])
    {
        parent::__construct($config);
        $this->params['maxValue'] = class_exists('rock\file\UploadedFile')
            ? UploadedFile::getSizeLimit($maxValue)
            : FileHelper::sizeToBytes(ini_get('upload_max_filesize'));
        $this->params['inclusive'] = $inclusive;
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        $maxValue = $this->params['maxValue'];
        if ($input instanceof UploadedFile) {
            if ($input->error === UPLOAD_ERR_INI_SIZE || $input->error === UPLOAD_ERR_FORM_SIZE) {
                return false;
            }
            $input = $input->size;
            $maxValue = UploadedFile::getSizeLimit($maxValue);
        } elseif ($input instanceof \SplFileInfo) {
            $input = $input->getSize();
        }
        if ($this->params['inclusive']) {
            return $input <= $maxValue;
        } else {
            return $input < $maxValue;
        }
    }
} 