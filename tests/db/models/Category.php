<?php
namespace rockunit\db\models;

use rock\db\ActiveQuery;

/**
 * Class Category.
 *
 * @property integer $id
 * @property string $name
 */
class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLimitedItems()
    {
        return $this->hasMany(Item::className(), ['category_id' => 'id'])
            ->onCondition(['item.id' => [1, 2, 3]]);
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['item_id' => 'id'])->via('items');
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'order_id'])->via('orderItems');
    }
}
