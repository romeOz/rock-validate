<?php
namespace rockunit;

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

    public function testFunctionNamesAsString()
    {
        $v = Validate::call('is_string');
        $this->assertTrue($v->validate('test'));
        $v = Validate::call('strpos', ['e']);
        $this->assertTrue($v->validate('test'));
        $v = Validate::call('strpos', ['e'])->call('strpos', ['s']);
        $this->assertTrue($v->validate('test'));

        // fail
        $v = Validate::call('strpos', ['a']);
        $this->assertFalse($v->validate('test'));
        $v = Validate::call('strpos', ['e'])->call('strpos', ['a']);
        $this->assertFalse($v->validate('test'));
        $v = Validate::call('strpos', ['a'])->call('strpos', ['e']);
        $this->assertFalse($v->validate('test'));

    }

    /**
     * @expectedException \rock\validate\ValidateException
     */
    public function testInvalidCallbacksShouldRaiseComponentExceptionUponInstantiation()
    {
        $v = Validate::call(new \stdClass);
        $this->assertTrue($v->validate('foo'));
    }
}

