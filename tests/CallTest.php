<?php
namespace rockunit\validate;

use rock\validate\Validate;

class CallTest extends \PHPUnit_Framework_TestCase
{
    public function thisIsASampleCallbackUsedInsideThisTest()
    {
        return true;
    }

    public function testValid()
    {
        $callback = Validate::call(function() {
            return true;
        });
        $this->assertTrue($callback->validate(''));
    }

    public function testInvalid()
    {
        $callback = Validate::call(function() {
            return false;
        });
        $this->assertFalse($callback->validate('invalid'));
    }

    public function testCallbackValidatorShouldAcceptArrayCallbackDefinitions()
    {
        $v = Validate::call([$this, 'thisIsASampleCallbackUsedInsideThisTest']);
        $this->assertTrue($v->validate('test'));
    }

    public function testCallbackValidatorShouldAcceptFunctionNamesAsString()
    {
        $v = Validate::call('is_string');
        $this->assertTrue($v->validate('test'));
    }

    /**
     * @expectedException \rock\validate\Exception
     */
    public function testInvalidCallbacksShouldRaiseComponentExceptionUponInstantiation()
    {
        $v = Validate::call(new \stdClass);
        $this->assertTrue($v->validate('foo'));
    }
}

