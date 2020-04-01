<?php
namespace Zf1Compat\View\Helper;

use Laminas\Form\Element\Text;
use Laminas\Form\View\Helper\FormText as FormTextHelper;

class FormText
{
    /**
     * Generates a 'text' element.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are extracted in place of added parameters.
     * @param mixed $value The element value.
     * @param array $attribs Attributes for the element tag.
     * @return string The element XHTML.
     */
    public function __invoke($name, $value = null, array $attribs = null)
    {
        $element = new Text($name);
        $element->setAttributes($attribs);
        $element->setValue($value);

        $helper = new FormTextHelper();

        return $helper($element);
    }
}
