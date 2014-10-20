<?php
namespace rockunit\validate;

use rock\validate\Validate;

class BoolTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $validator = Validate::bool();
        $this->assertTrue($validator->validate(true));
        $this->assertTrue($validator->validate(false));
    }

    public function testInvalid()
    {
        $validator = Validate::bool();
        $this->assertFalse($validator->validate('foo'));
        $this->assertFalse($validator->validate(123123));
        $this->assertFalse($validator->validate(new \stdClass()));
        $this->assertFalse($validator->validate([]));
        $this->assertFalse($validator->validate(1));
        $this->assertFalse($validator->validate(0));
        $this->assertFalse($validator->validate(null));
    }

    public function testInvalidRu()
    {
        $validator = Validate::locale(Validate::RU)->bool();
        $this->assertFalse($validator->validate('foo'));;
    }
}

