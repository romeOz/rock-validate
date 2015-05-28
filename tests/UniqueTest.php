<?php

namespace rockunit\core\validate;


use rock\components\Model;
use rock\validate\ActiveValidate;
use rockunit\db\DatabaseTestCase;
use rockunit\db\models\ActiveRecord;
use rockunit\db\models\Order;
use rockunit\db\models\OrderItem;
use rockunit\models\FakedValidationModel;
use rockunit\models\ValidatorTestMainModel;
use rockunit\models\ValidatorTestRefModel;
use rockunit\models\ValidatorTestRefRulesModel;

class UniqueTest extends DatabaseTestCase
{
    protected $driverName = 'mysql';

    public function setUp()
    {
        parent::setUp();
        ActiveRecord::$connection = $this->getConnection();
    }

    public function testValidateAttributeDefault()
    {
        $m = ValidatorTestMainModel::find()->one();
        $val = ActiveValidate::unique($m);
        $this->assertTrue($val->validate('id'));

        $m = ValidatorTestRefModel::findOne(1);
        $val = ActiveValidate::unique($m);
        $this->assertFalse($val->validate('ref'));

        // new record:
        $m = new ValidatorTestRefModel();
        $m->ref = 5;
        $val = ActiveValidate::unique($m);
        $this->assertFalse($val->validate('ref'));
        $this->assertNotEmpty($val->getErrors());
        $m = new ValidatorTestRefModel();
        $m->id = 7;
        $m->ref = 12121;
        $val = ActiveValidate::unique($m);
        $this->assertTrue($val->validate('ref'));
        $this->assertEmpty($val->getErrors());
        $m->save(false);
        $this->assertTrue($val->validate('ref'));

        // array error
        $m = FakedValidationModel::createWithAttributes(['attr_arr' => ['a', 'b']]);
        $val = ActiveValidate::unique($m);
        $this->assertFalse($val->validate('attr_arr'));
    }

    public function testModelRulesFail()
    {
        $rules = [
            [
                Model::RULE_VALIDATE, 'ref', 'unique',
            ],
        ];
        $m = new ValidatorTestRefRulesModel();
        $m->rules = $rules;
        $m->ref = 5;
        $this->assertFalse($m->save());
        $this->assertNotEmpty($m->getErrors('ref'));
        $this->assertTrue($m->save(false));

        // target attributes
        $rules = [
            [
                Model::RULE_VALIDATE, 'ref', 'unique' => ['id'],
            ],
        ];
        $m = new ValidatorTestRefRulesModel();
        $m->rules = $rules;
        $m->ref = 6;
        $this->assertFalse($m->save());
        $this->assertNotEmpty($m->getErrors('ref'));
        $this->assertTrue($m->save(false));

        $rules = [
            [
                Model::RULE_VALIDATE, 'id', 'unique' => ['ref', ValidatorTestRefRulesModel::className()],
            ],
        ];
        $m = new ValidatorTestMainModel();
        $m->rules = $rules;
        $m->id = 5;
        $this->assertFalse($m->save());
        $this->assertTrue($m->save(false));
    }

    public function testModelRulesSuccess()
    {
        $rules = [
            [
                Model::RULE_VALIDATE, 'ref', 'unique',
            ],
        ];
        $m = new ValidatorTestRefRulesModel();
        $m->rules = $rules;
        $m->ref = 12121;
        $this->assertTrue($m->save());
        $this->assertEmpty($m->getErrors());

        // target attributes
        $rules = [
            [
                Model::RULE_VALIDATE, 'ref', 'unique' => ['id'],
            ],
        ];
        $m = new ValidatorTestRefRulesModel();
        $m->rules = $rules;
        $m->ref = 8;
        $this->assertTrue($m->save());
        $this->assertEmpty($m->getErrors());

        $rules = [
            [
                Model::RULE_VALIDATE, 'id', 'unique' => ['ref', ValidatorTestRefRulesModel::className()],
            ],
        ];
        $m = new ValidatorTestMainModel();
        $m->rules = $rules;
        $m->id = 9;
        $this->assertTrue($m->save());
    }

    public function testValidateAttributeOfNonARModel()
    {
        $m = FakedValidationModel::createWithAttributes(['attr_1' => 5, 'attr_2' => 1313]);
        $val = ActiveValidate::unique($m, 'ref', ValidatorTestRefModel::className());
        $this->assertFalse($val->validate('attr_1'));
        $this->assertTrue($val->validate('attr_2'));
    }

    public function testValidateNonDatabaseAttribute()
    {
        $m = ValidatorTestMainModel::findOne(1);
        $val = ActiveValidate::unique($m, 'ref', ValidatorTestRefModel::className());
        $this->assertTrue($val->validate('testMainVal'));

        $m = ValidatorTestMainModel::findOne(1);
        $m->testMainVal = 4;
        $val = ActiveValidate::unique($m, 'ref', ValidatorTestRefModel::className());
        $this->assertFalse($val->validate('testMainVal'));

    }

    public function testValidateAttributeAttributeNotInTableException()
    {
        $this->setExpectedException(\rock\db\DbException::className());
        $m = new ValidatorTestMainModel();
        $val = ActiveValidate::unique($m);
        $val->validate('testMainVal');
    }

    public function testValidateCompositeKeys()
    {
        // validate old record
        $m = OrderItem::findOne(['order_id' => 1, 'item_id' => 2]);
        $val = ActiveValidate::unique($m, ['order_id', 'item_id'], OrderItem::className());
        $this->assertTrue($val->validate('order_id'));

        $m->item_id = 1;
        $val = ActiveValidate::unique($m, ['order_id', 'item_id'], OrderItem::className());
        $this->assertFalse($val->validate('order_id'));

        // validate new record
        $m = new OrderItem(['order_id' => 1, 'item_id' => 2]);
        $val = ActiveValidate::unique($m, ['order_id', 'item_id'], OrderItem::className());
        $this->assertFalse($val->validate('order_id'));

        $m = new OrderItem(['order_id' => 10, 'item_id' => 2]);
        $val = ActiveValidate::unique($m, ['order_id', 'item_id'], OrderItem::className());
        $this->assertTrue($val->validate('order_id'));

        // validate old record
        $m = Order::findOne(1);
        $val = ActiveValidate::unique($m, ['id' => 'order_id'], OrderItem::className());
        $this->assertFalse($val->validate('id'));
        $m = Order::findOne(1);
        $m->id = 2;
        $val = ActiveValidate::unique($m, ['id' => 'order_id'], OrderItem::className());
        $this->assertFalse($val->validate('id'));
        $m = Order::findOne(1);
        $m->id = 10;
        $val = ActiveValidate::unique($m, ['id' => 'order_id'], OrderItem::className());
        $this->assertTrue($val->validate('id'));
        $m = new Order(['id' => 1]);
        $val = ActiveValidate::unique($m, ['id' => 'order_id'], OrderItem::className());
        $this->assertFalse($val->validate('id'));
        $m = new Order(['id' => 10]);
        $val = ActiveValidate::unique($m, ['id' => 'order_id'], OrderItem::className());
        $this->assertTrue($val->validate('id'));
    }
}
