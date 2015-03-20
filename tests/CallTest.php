<?php
namespace rockunit;

use rock\base\ClassName;
use rock\validate\Validate;

class CallTest extends \PHPUnit_Framework_TestCase
{
    public function thisIsASampleCallbackUsedInsideThisTest()
    {
        return true;
    }

    public function testValid()
    {
        $call = Validate::call(function($value) {
            return $value === 'valid';
        });
        $this->assertTrue($call->validate('valid'));

        $call = Validate::call([CallClass::className(), 'valid']);
        $this->assertTrue($call->validate('valid'));
    }

    public function testInvalid()
    {
        $call = Validate::call(function($value) {
            return $value === 'valid';
        });
        $this->assertFalse($call->validate('invalid'));

        $call = Validate::call([CallClass::className(), 'invalid']);
        $this->assertFalse($call->validate('valid'));
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
}

class CallClass
{
    use ClassName;

    public static function valid($value)
    {
        return $value === 'valid';
    }

    public static function invalid($value)
    {
        return $value === 'invalid';
    }
}

