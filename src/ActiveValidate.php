<?php

namespace rock\validate;


use rock\components\Model;
use rock\validate\rules\Unique;

/**
 * Class ValidateModel
 *
 * @method static Validate unique(Model $m, $targetAttribute = null, $targetClass = null, $filter = null)
 *
 * @codeCoverageIgnore
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
                    'en' => \rock\validate\locale\en\Unique::className(),
                    'ru' => \rock\validate\locale\ru\Unique::className(),
                ]
            ],
        ];
    }
}