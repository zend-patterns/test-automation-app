<?php

namespace Zf1Compat\View\Helper;

use Laminas\Form\Element\Select;
use Laminas\Form\View\Helper\FormSelect as FormSelectHelper;

class FormSelect
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Generates 'select' list of options.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are extracted in place of added parameters.
     *
     * @param mixed $value The option value to mark as 'selected'; if an
     * array, will mark all values in the array as 'selected' (used for
     * multiple-select elements).
     *
     * @param array|string $attribs Attributes added to the 'select' tag.
     * the optional 'optionClasses' attribute is used to add a class to
     * the options within the select (associative array linking the option
     * value to the desired class)
     *
     * @param array $options An array of key-value pairs where the array
     * key is the radio value, and the array value is the radio text.
     *
     * @param string $listsep When disabled, use this list separator string
     * between list values.
     *
     * @return string The select tag and options XHTML.
     */
    public function __invoke(
        $name,
        $value = null,
        $attribs = null,
        $options = null,
        $listsep = "<br />\n"
    ) {
        if (empty($name)) {
            $name = '_';
        }

        $fixKey = 'disabled';
        if ($attribs != null && array_key_exists($fixKey, $attribs) && empty($attribs[$fixKey])) {
            $attribs[$fixKey] = $fixKey;
        }

        $element = new Select($name);
        $element->setValueOptions((array)$options);
        $removeMulti = !isset($attribs['multiple']) && !is_scalar($value);
        if (!is_scalar($value)) {
            $value = (array)$value;
            $attribs['multiple'] = true;
        }
        $element->setAttributes($attribs);
        $element->setValue($value);

        $helper = new FormSelectHelper();

        if (isset($this->config['additional_attributes']) && is_array($this->config['additional_attributes'])) {
            foreach ($this->config['additional_attributes'] as $attribute) {
                $helper->addValidAttributePrefix($attribute);
            }
        }

        $text = $helper($element);
        if ($removeMulti) {
            $text = preg_replace('/<select name="(.*?)"(.*?) multiple="multiple">/', '<select name="' . $name . '"$2>', $text);
        }

        return $text;
    }
}
