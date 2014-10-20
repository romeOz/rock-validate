<?php

namespace rockunit\validate;



use rock\validate\Validate;
use rockunit\mocks\SymbolicLinkMock;

class SymbolicLinkTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Validate */
    protected $v;
    protected function setUp()
    {
        $config = [
            'rules' => [
                'symbolicLink' => [
                    'class' => SymbolicLinkMock::className(),
                    'locales' => [
                        Validate::EN => \rock\validate\locale\en\SymbolicLink::className(),
                        Validate::RU => \rock\validate\locale\ru\SymbolicLink::className(),
                    ]
                ],
            ]
        ];
        $this->v = new Validate($config);
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        unset($GLOBALS['is_link']);
    }

    public function testValid()
    {
        $GLOBALS['is_link'] = true;

        $v = $this->v->symbolicLink();
        $input = __DIR__ . '/../src/valid/readable/link.lnk';
        $this->assertTrue($v->validate($input));
    }

    public function testInvalid()
    {
        $GLOBALS['is_link'] = false;

        $v = $this->v->symbolicLink();
        $input = __DIR__ . '/../src/valid/readable/file.txt';
        $this->assertFalse($v->validate($input));
    }

    public function testShouldValidateObjects()
    {
        $v = $this->v->symbolicLink();
        $object = $this->getMock('SplFileInfo', ['isLink'], ['somelink.lnk']);
        $object->expects($this->once())
                ->method('isLink')
                ->will($this->returnValue(true));

        $this->assertTrue($v->validate($object));
    }
}