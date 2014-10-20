<?php
namespace rockunit\validate;

use rock\validate\Validate;
use rockunit\mocks\ReadableMock;

class ReadableTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Validate */
    protected $v;
    protected function setUp()
    {
        $config = [
            'rules' => [
                'readable' => [
                    'class' => ReadableMock::className(),
                    'locales' => [
                        Validate::EN => \rock\validate\locale\en\Readable::className(),
                        Validate::RU => \rock\validate\locale\ru\Readable::className(),
                    ]
                ],
            ]
        ];
        $this->v = new Validate($config);
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        unset($GLOBALS['is_readable']);
    }

    public function testValid()
    {
        $GLOBALS['is_readable'] = true;

        $v = $this->v->readable();
        $input = __DIR__ . '/../src/valid/readable/file.txt';
        $this->assertTrue($v->validate($input));
    }

    public function testInvalide()
    {
        $GLOBALS['is_readable'] = false;

        $v = $this->v->readable();
        $input = __DIR__ . '/../src/invalid/readable/_file.txt';

        $this->assertFalse($v->validate($input));
    }

    public function testShouldValidateObjects()
    {
        $v = $this->v->readable();
        $object = $this->getMock('SplFileInfo', ['isReadable'], ['somefile.txt']);
        $object->expects($this->once())
            ->method('isReadable')
            ->will($this->returnValue(true));

        $this->assertTrue($v->validate($object));
    }
}