<?php

namespace rockunit\models;


use rockunit\db\models\ActiveRecord;

class ValidatorTestMainModel extends ActiveRecord
{
    public $testMainVal = 1;
    public $rules = [];

    public function rules()
    {
        if (!empty($this->rules)) {
            return $this->rules;
        }
        return parent::rules();
    }


    public static function tableName()
    {
        return 'validator_main';
    }

    public function getReferences()
    {
        return $this->hasMany(ValidatorTestRefModel::className(), ['ref' => 'id']);
    }
}
