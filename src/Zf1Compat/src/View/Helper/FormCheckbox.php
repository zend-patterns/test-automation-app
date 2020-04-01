<?php
namespace Zf1Compat\View\Helper;

use Laminas\Form\Element\Checkbox;
use Laminas\Form\View\Helper\FormCheckbox as FormCheckboxHelper;

class FormCheckbox
{
    public const CHECKED_OPTION = 'checked';
    public const UNCHECKED_OPTION = 'unChecked';

    /**
     * Generates a 'checkbox' element.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are extracted in place of added parameters.
     * @param mixed $value The element value.
     * @param array $attribs Attributes for the element tag.
     * @param array $checkedOptions
     * @return string The element XHTML.
     */
    public function __invoke($name, $value = null, array $attribs = [], array $checkedOptions = null)
    {
        $element = new Checkbox($name);
        $element->setAttributes($attribs);
        if (isset($checkedOptions[self::UNCHECKED_OPTION])) {
            $element->setUncheckedValue($checkedOptions[self::UNCHECKED_OPTION]);
        }
        if (isset($checkedOptions[self::CHECKED_OPTION])) {
            $element->setCheckedValue($checkedOptions[self::CHECKED_OPTION]);
        }
        $element->setValue($value);

        $helper = new FormCheckboxHelper();

        return $helper($element);
    }
}
