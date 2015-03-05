<?php

namespace rockunit\models;

use rockunit\db\models\ActiveRecord;

class ValidatorTestRefRulesModel extends ActiveRecord
{
    public $test_val = 2;
    public $test_val_fail = 99;

    public $rules = [];
    public function rules()
    {
        if (!empty($this->rules)) {
            return $this->rules;
        }
        return [
            [
                self::RULE_VALIDATE, 'ref', 'unique',
            ],
        ];
    }

    public static function tableName()
    {
        return 'validator_ref';
    }

    public function getMain()
    {
        return $this->hasOne(ValidatorTestMainModel::className(), ['id' => 'ref']);
    }
}
