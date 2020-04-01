<?php

namespace Test\Unit\Zf1Compat\View\Helper;

use PHPUnit\Framework\TestCase;
use Zf1Compat\View\Helper\FormCheckbox;

final class FormCheckboxTest extends TestCase
{
    private const SPACE_SIGN = '&#x20;';

    /**
     * @var FormCheckbox
     */
    private $helper;

    protected function setUp()
    {
        $this->helper = new FormCheckbox();
    }

    public function testInvoke_WithNameOnly_ReturnsBaseCheckbox()
    {
        self::assertEquals(
            '<input type="hidden" name="name" value="0"><input type="checkbox" name="name" value="1">',
            $this->helper->__invoke('name')
        );
    }

    public function testInvoke_WithNameAndValue_ReturnsSetValue()
    {
        self::assertEquals(
            '<input type="hidden" name="name" value="0"><input type="checkbox" name="name" value="1">',
            $this->helper->__invoke('name', "value")
        );
    }

    public function testInvoke_WithNameValueAndAttribsChecked_ReturnsAttribCheckValue()
    {
        self::assertEquals(
            '<input type="hidden" name="name" value="0"><input type="checkbox" name="name" checked="checked" value="1">',
            $this->helper->__invoke('name', "value", ["checked" => 1])
        );
    }

    public function testInvoke_WithCheckOptions_ReturnsCheckedAttribute()
    {
        self::assertEquals(
            '<input type="hidden" name="name" value="N"><input type="checkbox" name="name" readonly="readonly" onclick="return'.self::SPACE_SIGN.'false" value="Y" checked="checked">',
            $this->helper->__invoke('name', "Y", ['readonly'=>true, 'onclick' => 'return false'], ['checked' => 'Y', 'unChecked' => 'N'])
        );
    }

    public function testInvoke_WithCheckOptions_DoesNotSetCheckedAttribute()
    {
        self::assertEquals(
            '<input type="hidden" name="name" value="N"><input type="checkbox" name="name" readonly="readonly" onclick="return'.self::SPACE_SIGN.'false" value="Y">',
            $this->helper->__invoke('name', "N", ['readonly'=>true, 'onclick' => 'return false'], ['checked' => 'Y', 'unChecked' => 'N'])
        );
    }
}
