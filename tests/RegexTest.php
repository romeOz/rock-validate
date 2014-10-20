<?php
namespace rockunit\validate;

use rock\validate\Validate;

class RegexTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $v = Validate::regex('/^[a-z]+$/');
        $this->assertTrue($v->validate('foo'));
        $this->assertFalse($v->validate('barFoo'));

        $v = Validate::regex('/^[a-z]+$/i');
        $this->assertTrue($v->validate('barFoo'));
    }

    public function testInvalid()
    {
        $v = Validate::regex('/^w+$/');
        $this->assertFalse($v->validate('foo'));
    }
}

