<?php

namespace rock\validate;


use rock\components\Model;
use rock\db\validate\rules\Unique;

/**
 * AR validate rules.
 *
 * @method static Validate unique(Model $m, $targetAttribute = null, $targetClass = null, $filter = null)
 *
 * @package rock\validate
 */
class ActiveValidate extends Validate
{
    public function existsModelRule($name)
    {
        $rules = $this->modelRules();
        return !empty($rules) && isset($rules[$name]);
    }

    protected function defaultRules()
    {
        return array_merge(parent::defaultRules(), $this->modelRules());
    }

    protected function modelRules()
    {
        return [
            'unique' => [
                'class' => Unique::className(),
                'locales' => [
                    'en' => \rock\db\validate\locale\en\Unique::className(),
                    'ru' => \rock\db\validate\locale\ru\Unique::className(),
                ]
            ],
            'mongoId' => [
                'class' => \rock\mongodb\validate\MongoIdRule::className(),
                'locales' => [
                    'en' => \rock\mongodb\validate\locale\en\MongoIdLocale::className(),
                    'ru' => \rock\mongodb\validate\locale\ru\MongoIdLocale::className(),
                ]
            ],
        ];
    }
}