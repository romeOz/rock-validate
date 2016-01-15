<?php
namespace rockunit;

use rock\validate\Validate;

class DirectoryTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $rule = Validate::directory();
        $this->assertTrue($rule->validate(__DIR__ . DIRECTORY_SEPARATOR . 'mocks'));
    }

    /**
     * @dataProvider providerInvalid
     */
    public function testInvalid($input)
    {
        $rule = Validate::directory();
        $this->assertFalse($rule->validate($input));
    }

    /**
     * @dataProvider providerForDirectoryObjects
     */
    public function testDirectoryWithObjects($object, $valid)
    {
        $rule = Validate::directory();
        $this->assertEquals($valid, $rule->validate($object));
    }

    public function providerForDirectoryObjects()
    {
        return [
            [new \SplFileInfo(__DIR__), true],
            [new \SplFileInfo(__FILE__), false],
            /**
             * PHP 5.4 does not allows to use SplFileObject with directories.
             * array(new \SplFileObject(__DIR__), true),
             */
            [new \SplFileObject(__FILE__), false],
        ];
    }

    public function providerInvalid()
    {
        return array_chunk(
            [
                __FILE__,
                __DIR__ . '/../../../../../README.md',
                __DIR__ . '/../../../../../composer.json',
                new \stdClass(),
                [__DIR__],
            ],
            1
        );
    }
}