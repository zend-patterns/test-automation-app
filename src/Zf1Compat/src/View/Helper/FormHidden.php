<?php
namespace Zf1Compat\View\Helper;

use Laminas\Form\Element\Hidden;
use Laminas\Form\View\Helper\FormHidden as FormHiddenHelper;

class FormHidden
{
    /**
     * Generates a 'hidden' element.
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
        $element = new Hidden($name);
        $element->setAttributes($attribs);
        $element->setValue($value);

        $helper = new FormHiddenHelper();

        return $helper($element);
    }
}
