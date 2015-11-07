<?php
namespace rockunit;

use DateTime;
use rock\validate\Validate;

class DateTest extends \PHPUnit_Framework_TestCase
{
    public function testDateEmptyShouldValidate()
    {
        $v = Validate::date();
        $this->assertTrue($v->validate(''));
    }

    public function testDateWithoutFormatShouldValidate()
    {
        $v = Validate::date();
        $this->assertTrue($v->validate('today'));
    }

    public function testDateTimeInstancesShouldAlwaysValidate()
    {
        $v = Validate::date();
        $this->assertTrue($v->validate(new DateTime('today')));

        $v = Validate::date('Y-m-d');
        $this->assertTrue($v->validate((new \rock\date\DateTime('02.02.1950'))->setDefaultFormat('Y-m-d')->format()));
    }

    public function testInvalidDateShouldFail()
    {
        $v = Validate::date();
        $this->assertFalse($v->validate('aids'));
    }
    public function testInvalidDateShouldFail_on_invalid_conversions()
    {
        $v = Validate::date('Y-m-d');
        $this->assertFalse($v->validate('2009-12-00'));

        $this->assertFalse($v->validate((new \rock\date\DateTime('02.02.1950'))->setDefaultFormat('Y.m.d')->format()));
    }

    public function testAnyObjectExceptDateTimeInstancesShouldFail()
    {
        $v = Validate::date();
        $this->assertFalse($v->validate(new \stdClass));
    }
}