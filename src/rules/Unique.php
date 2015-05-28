<?php

namespace rock\validate\rules;

use rock\base\BaseException;
use rock\components\Model;
use rock\db\common\ActiveRecordInterface;
use rock\log\Log;
use rock\validate\ValidateException;

/**
 * UniqueValidator validates that the attribute value is unique in the specified database table.
 *
 * UniqueValidator checks if the value being validated is unique in the table column specified by
 * the ActiveRecord class {@see \rock\validate\rules\Unique::$targetClass} and the attribute {@see \rock\validate\rules\Unique::$targetAttribute}.
 *
 * The followings are examples of validation rules using this validator:
 *
 * ```php
 * // a1 needs to be unique
 * ['a1', 'unique']
 * // a1 needs to be unique, but column a2 will be used to check the uniqueness of the a1 value
 * ['a1', 'unique' => ['a2']]
 * ```
 */
class Unique extends Rule
{
    /**
     * @var string|array the name of the ActiveRecord attribute that should be used to
     * validate the uniqueness of the current attribute value. If not set, it will use the name
     * of the attribute currently being validated. You may use an array to validate the uniqueness
     * of multiple columns at the same time. The array values are the attributes that will be
     * used to validate the uniqueness, while the array keys are the attributes whose values are to be validated.
     * If the key and the value are the same, you can just specify the value.
     */
    public $targetAttribute;
    /**
     * @var string the name of the ActiveRecord class that should be used to validate the uniqueness
     * of the current attribute value. If not set, it will use the ActiveRecord class of the attribute being validated.
     * @see targetAttribute
     */
    public $targetClass;
    /**
     * @var string|array|\Closure additional filter to be applied to the DB query used to check the uniqueness of the attribute value.
     * This can be a string or an array representing the additional query condition (refer to {@see \rock\db\Query::where()}
     * on the format of query condition), or an anonymous function with the signature `function ($query)`, where `$query`
     * is the {@see \rock\db\Query|Query} object that you can modify in the function.
     */
    public $filter;


    /** @var  Model */
    protected $model;

    public function __construct($model, $targetAttribute = null, $targetClass = null, $filter = null, $config = [])
    {
        $this->parentConstruct($config);
        $this->model = $model;
        $this->targetClass = $targetClass;
        $this->targetAttribute = $targetAttribute;
        $this->filter = $filter;
    }

    /**
     * @inheritdoc
     */
    public function validate($attribute)
    {
        /* @var $targetClass ActiveRecordInterface */
        $targetClass = $this->targetClass === null ? get_class($this->model) : $this->targetClass;
        $targetAttribute = $this->targetAttribute === null ? $attribute : $this->targetAttribute;
        if (is_array($targetAttribute)) {
            $params = [];
            foreach ($targetAttribute as $k => $v) {
                $params[$v] = is_integer($k) ? $this->model->$v : $this->model->$k;
            }
            $this->params['value'] = $params;
        } else {
            $params = [$targetAttribute => $this->model->$attribute];
            $this->params['value'] = $this->model->$attribute;
        }
        foreach ($params as $value) {
            if (is_array($value)) {
                if (class_exists('\rock\log\Log')) {
                    $message = BaseException::convertExceptionToString(new ValidateException("{$targetClass}::{$targetAttribute} is invalid: type array()"));
                    Log::err($message);
                }
                return false;
            }
        }

        $query = $targetClass::find();
        $query->andWhere($params);

        if ($this->filter instanceof \Closure) {
            call_user_func($this->filter, $query);
        } elseif ($this->filter !== null) {
            $query->andWhere($this->filter);
        }

        if (!$this->model instanceof ActiveRecordInterface || $this->model->getIsNewRecord()) {
            // if current $model isn't in the database yet then it's OK just to call exists()
            $exists = $query->exists();
        } else {
            // if current $model is in the database already we can't use exists()
            /* @var $models ActiveRecordInterface[] */
            $models = $query->limit(2)->all();
            $n = count($models);
            if ($n === 1) {
                $keys = array_keys($params);
                $pks = $targetClass::primaryKey();
                sort($keys);
                sort($pks);
                if ($keys === $pks) {
                    // primary key is modified and not unique
                    $exists = $this->model->getOldPrimaryKey() != $this->model->getPrimaryKey();
                } else {
                    // non-primary key, need to exclude the current record based on PK
                    $exists = $models[0]->getPrimaryKey() != $this->model->getOldPrimaryKey();
                }
            } else {
                $exists = $n > 1;
            }
        }

        return !$exists;
    }
}