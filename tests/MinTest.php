<?php
namespace rockunit;

use rock\validate\Validate;

class MinTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerValid
     */
    public function testValid($minValue, $inclusive, $input)
    {
        $min = Validate::min($minValue, $inclusive);
        $this->assertTrue($min->validate($input));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($minValue, $inclusive, $input)
    {
        $min = Validate::min($minValue, $inclusive);
        $this->assertFalse($min->validate($input));
    }

    public function providerValid()
    {
        return [
            [100, true, ''],
            [100, false, ''],
            [100, false, 165.0],
            [-100, false, 200],
            [200, true, 200],
            [200, false, 300],
            [new \DateTime('2005-11-30 10:30:00'), true, '2005-11-30 10:30:00'],
        ];
    }

    public function providerInvalid()
    {
        return [
            [500, false, 300],
            [0, false, -250],
            [0, false, -50],
            [50, false, 50],
            [new \DateTime(), false, 'aids'],
            [new \DateTime('2005-11-30 10:30:00'), false, '2005-11-30 10:30:00'],
        ];
    }
}