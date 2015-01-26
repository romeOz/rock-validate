<?php
namespace rockunit;

use \DateTime;
use rock\validate\rules\Between;
use rock\validate\Validate;

class BetweenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($min, $max, $inclusive, $input)
    {
        $o = Validate::between($min, $max, $inclusive);
        $this->assertTrue($o->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($min, $max, $inclusive, $input)
    {
        $o = Validate::between($min, $max, $inclusive);
        $this->assertFalse($o->validate($input));
    }

    /**
     * @expectedException \rock\validate\ValidateException
     */
    public function testInvalidConstructionParamsShouldRaiseException()
    {
       new Between(10, 5);
    }

    public function providerValid()
    {
        return [
            [0, 1, true, 0],
            [0, 1, true, 1],
            [10, 20, false, 15],
            [10, 20, true, 20],
            [-10, 20, false, -5],
            [-10, 20, false, 0],
            ['a', 'z', false, 'j'],
            [
                new DateTime('yesterday'),
                new DateTime('tomorrow'),
                false,
                new DateTime('now')
            ],
        ];
    }

    public function providerInvalid()
    {
        return [
            [0, 1, false, 0],
            [0, 1, false, 1],
            [0, 1, false, 2],
            [0, 1, false, -1],
            [10, 20, false, 999],
            [10, 20, false, 20],
            [-10, 20, false, -11],
            ['a', 'j', false, 'z'],
            [
                new DateTime('yesterday'),
                new DateTime('now'),
                false,
                new DateTime('tomorrow')
            ],
        ];
    }
}