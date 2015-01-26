<?php
namespace rockunit;

use rock\validate\Validate;

class LengthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerForValidLength
     */
    public function testLengthInsideBoundsShouldReturnTrue($string, $min, $max)
    {
        $v = Validate::length($min, $max);
        $this->assertTrue($v->validate($string));
    }

    /**
     * @dataProvider providerForInvalidLengthInclusive
     */
    public function testLengthOutsideBoundsShouldThrowLengthException($string, $min, $max)
    {
        $v = Validate::length($min, $max, false);
        $this->assertFalse($v->validate($string));
    }

    /**
     * @dataProvider providerForInvalidLength
     */
    public function testLengthOutsideValidBoundsShouldThrowLengthException($string, $min, $max)
    {
        $validator = Validate::length($min, $max);
        $this->assertFalse($validator->validate($string));
    }

    /**
     * @dataProvider providerForComponentException
     * @expectedException \rock\validate\ValidateException
     */
    public function testThrowException($string, $min, $max)
    {
        $validator = Validate::length($min, $max);
        $this->assertFalse($validator->validate($string));
    }

    public function providerForValidLength()
    {
        return [
            ['', 1, 15],
            [123456, 1, 6],
            ['alganet', 1, 15],
            ['ççççç', 4, 6],
            [range(1, 20), 1, 30],
            [(object) ['foo'=>'bar', 'bar'=>'baz'], 1, 2],
            ['alganet', 1, null], //null is a valid max length, means "no maximum",
            ['alganet', null, 15] //null is a valid min length, means "no minimum"
        ];
    }

    public function providerForInvalidLengthInclusive()
    {
        return [

            ['alganet', 1, 7],
            [range(1, 20), 1, 20],
            ['alganet', 7, null], //null is a valid max length, means "no maximum",
            ['alganet', null, 7] //null is a valid min length, means "no minimum"
        ];
    }

    public function providerForInvalidLength()
    {
        return [
            ['alganet', 1, 3],
            [(object) ['foo'=>'bar', 'bar'=>'baz'], 3, 5],
            [range(1, 50), 1, 30],
        ];
    }

    public function providerForComponentException()
    {
        return [
            ['alganet', 'a', 15],
            ['alganet', 1, 'abc d'],
            ['alganet', 10, 1],
        ];
    }
}