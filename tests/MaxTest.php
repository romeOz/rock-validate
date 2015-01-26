<?php
namespace rockunit;

use rock\validate\Validate;

class MaxTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($maxValue, $inclusive, $input)
    {
        $max = Validate::max($maxValue, $inclusive);
        $this->assertTrue($max->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($maxValue, $inclusive, $input)
    {
        $max = Validate::max($maxValue, $inclusive);
        $this->assertFalse($max->validate($input));
    }

    public function providerValid()
    {
        return [
            [200, false, ''],
            [200, false, null],
            [200, false, []],
            [200, false, 165.0],
            [200, false, -200],
            [200, true, 200],
            [200, false, 0],
            [new \DateTime('2005-11-30 10:30:00'), true, '2005-11-30 10:30:00'],
        ];
    }

    public function providerInvalid()
    {
        return [
            [200, false, 300],
            [200, false, 250],
            [200, false, 1500],
            [200, false, 200],
            [new \DateTime(), false, 'aids'],
            [new \DateTime('2005-11-30 10:30:00'), false, '2005-11-30 10:30:00'],
        ];
    }
}