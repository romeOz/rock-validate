<?php

namespace rockunit;


use rock\validate\Validate;
use rockunit\mocks\WritableMock;

class WritableTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Validate */
    protected $v;
    protected function setUp()
    {
        $config = [
            'rules' => [
                'writable' => [
                    'class' => WritableMock::className(),
                    'locales' => [
                        'en' => \rock\validate\locale\en\Writable::className(),
                        'ru' => \rock\validate\locale\ru\Writable::className(),
                    ]
                ],
            ]
        ];
        $this->v = new Validate($config);
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        unset($GLOBALS['is_writable']);
    }

    public function testValidWritableFileShouldReturnTrue()
    {
        $GLOBALS['is_writable'] = true;

        $v = $this->v->writable();
        $input = __DIR__ . '/../src/valid/readable/file.txt';
        $this->assertTrue($v->validate($input));
    }

    public function testInvalidWritableFileShouldReturnFalse()
    {
        $GLOBALS['is_writable'] = false;

        $v = $this->v->writable();
        $input = __DIR__ . '/../src/invalid/readable/file.txt';
        $this->assertFalse($v->validate($input));
    }

    public function testShouldValidateObjects()
    {
        $v = $this->v->writable();
        $object = $this->getMock('SplFileInfo', array('isWritable'), array('somefile.txt'));
        $object->expects($this->once())
                ->method('isWritable')
                ->will($this->returnValue(true));

        $this->assertTrue($v->validate($object));
    }

}
