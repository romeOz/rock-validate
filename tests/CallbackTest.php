<?php
namespace rockunit\validate;

use rock\validate\Validate;

class CallbackTest extends \PHPUnit_Framework_TestCase
{
    public function thisIsASampleCallbackUsedInsideThisTest()
    {
        return true;
    }

    public function testValid()
    {
        $callback = Validate::callback(function() {
            return true;
        });
        $this->assertTrue($callback->validate(''));
    }

    public function testInvalid()
    {
        $callback = Validate::callback(function() {
            return false;
        });
        $this->assertFalse($callback->validate('invalid'));
    }

    public function testCallbackValidatorShouldAcceptArrayCallbackDefinitions()
    {
        $v = Validate::callback([$this, 'thisIsASampleCallbackUsedInsideThisTest']);
        $this->assertTrue($v->validate('test'));
    }

    public function testCallbackValidatorShouldAcceptFunctionNamesAsString()
    {
        $v = Validate::callback('is_string');
        $this->assertTrue($v->validate('test'));
    }

    /**
     * @expectedException \rock\validate\Exception
     */
    public function testInvalidCallbacksShouldRaiseComponentExceptionUponInstantiation()
    {
        $v = Validate::callback(new \stdClass);
        $this->assertTrue($v->validate('foo'));
    }
}

