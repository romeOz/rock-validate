<?php
namespace rockunit\validate;

use rock\validate\Validate;

class IpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerForIp
     */
    public function testValidIpsValid($input, $options = null)
    {
        $ipValidator = Validate::ip();
        $this->assertTrue($ipValidator->validate($input));
    }

    /**
     * @dataProvider providerForIpBetweenRange
     */
    public function testIpsBetweenRangeValid($input, $networkRange)
    {
        $ipValidator = Validate::ip($networkRange);
        $this->assertTrue($ipValidator->validate($input));
    }

    /**
     * @dataProvider providerForNotIp
     */
    public function testInvalidIpsInvalid($input, $options=null)
    {
        $ipValidator = Validate::ip($options);
        $this->assertFalse($ipValidator->validate($input));
    }

    /**
     * @dataProvider providerForIpOutsideRange
     */
    public function testIpsOutsideRangeShouldReturnFalse($input, $networkRange)
    {
        $ipValidator = Validate::ip($networkRange);
        $this->assertFalse($ipValidator->validate($input));
    }

    /**
     * @expectedException \rock\validate\Exception
     */
    public function testThrowExceptionMinNetworkRange()
    {
        $ipValidator = Validate::ip('15-192.255.255.255');
        $this->assertFalse($ipValidator->validate('127.0.0.1'));
    }

    /**
     * @expectedException \rock\validate\Exception
     */
    public function testThrowExceptionMaxNetworkRange()
    {
        $ipValidator = Validate::ip('127.0.0.0-7');
        $this->assertFalse($ipValidator->validate('127.0.0.1'));
    }

    public function providerForIp()
    {
        return [
            ['127.0.0.1'],
        ];
    }

    public function providerForIpBetweenRange()
    {
        return [
            ['127.0.0.1', '127.*'],
            ['127.0.0.1', '127.0.*'],
            ['127.0.0.1', '127.0.0.*'],
            ['192.168.2.6', '192.168.*.6'],
            ['192.168.2.6', '192.*.2.6'],
            ['10.168.2.6', '*.168.2.6'],
            ['192.168.2.6', '192.168.*.*'],
            ['192.10.2.6', '192.*.*.*'],
            ['192.168.255.156', '*'],
            ['192.168.255.156', '*.*.*.*'],
            ['127.0.0.1', '127.0.0.0-127.0.0.255'],
            ['192.168.2.6', '192.168.0.0-192.168.255.255'],
            ['192.10.2.6', '192.0.0.0-192.255.255.255'],
            ['192.168.255.156', '0.0.0.0-255.255.255.255'],
            ['220.78.173.2', '220.78.168/21'],
            ['220.78.173.2', '220.78.168.0/21'],
            ['220.78.173.2', '220.78.168.0/255.255.248.0'],
        ];
    }

    public function providerForNotIp()
    {
        return [
            [null],
            ['j'],
            [' '],
            ['Foo'],
            ['192.168.0.1', FILTER_FLAG_NO_PRIV_RANGE],
        ];
    }

    public function providerForIpOutsideRange()
    {
        return [
            ['127.0.0.1', '127.0.1.*'],
            ['192.168.2.6', '192.163.*.*'],
            ['192.10.2.6', '193.*.*.*'],
            ['127.0.0.1', '127.0.1.0-127.0.1.255'],
            ['192.168.2.6', '192.163.0.0-192.163.255.255'],
            ['192.10.2.6', '193.168.0.0-193.255.255.255'],
            ['220.78.176.1', '220.78.168/21'],
            ['220.78.176.2', '220.78.168.0/21'],
            ['220.78.176.3', '220.78.168.0/255.255.248.0'],
        ];
    }

    /**
     * @dataProvider providerForInvalidRanges
     */
    public function testInvalidRangeShouldRaiseException($input)
    {
        $ipValidator = Validate::ip();
        $this->assertFalse($ipValidator->validate($input));
    }

    public function providerForInvalidRanges()
    {
        return [
            ['192.168'],
            ['asd'],
            ['192.168.0.0-192.168.0.256'],
            ['192.168.0.0-192.168.0.1/4'],
            ['192.168.0/1'],
            ['192.168.2.0/256.256.256.256'],
            ['192.168.2.0/8.256.256.256'],
        ];
    }
}