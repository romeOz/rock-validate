<?php
namespace rockunit;

use rock\validate\Validate;

class ClosureTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $this->assertTrue(Validate::closure()->validate(function(){}));
    }

    public function testInvalid()
    {
        $this->assertFalse(Validate::closure()->validate('foo'));
        $this->assertFalse(Validate::closure()->validate(''));
    }
}