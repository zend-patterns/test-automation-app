<?php
namespace Zf1Compat\View\Helper;

use Laminas\Form\Element\Radio;
use Laminas\Form\View\Helper\FormRadio as FormRadioHelper;

class FormRadio
{
    /**
     * Generates a set of radio button elements.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are extracted in place of added parameters.
     *
     * @param mixed $value The radio value to mark as 'checked'.
     *
     * @param array $options An array of key-value pairs where the array
     * key is the radio value, and the array value is the radio text.
     *
     * @param array|string $attribs Attributes added to each radio.
     *
     * @return string The radio buttons XHTML.
     */
    public function __invoke(
        $name,
        $value = null,
        $attribs = null,
        $options = null,
        $listsep = "<br />\n"
    ) {
        $element = new Radio($name);
        $element->setChecked($value);
        $element->setAttributes($attribs);
        $element->setValueOptions((array)$options);

        $helper = new FormRadioHelper();
        $helper->setSeparator($listsep);

        $text = $helper($element);
        $text = preg_replace('/ name="(.*?)"(.*?) value="(.*?)"/', ' name="$1" id="$1-$3"$2 value="$3"', $text);

        return $text;
    }
}
