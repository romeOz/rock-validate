<?php
namespace rockunit\db\models;


class ActiveRecord extends \rock\db\ActiveRecord
{
    public static $connection;

    public static function getConnection()
    {
        return static::$connection;
    }
}
