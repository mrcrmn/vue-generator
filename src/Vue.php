<?php

namespace mrcrmn\VueGenerator;

use mrcrmn\VueGenerator\HtmlTag;

class Vue extends HtmlTag
{
    /**
     * Alias for setting an attribute.
     *
     * @param string $prop
     * @param string $value
     * @param boolean $boolean
     * @return $this
     */
    public function addProp($prop, $value, $boolean = true)
    {
        return $this->setAttribute($prop, $value, $boolean);
    }

    /**
     * Returns the string representation for the HTML attribute.
     *
     * @return string
     */
    protected function getSingleAttribute($attribute, $value)
    {
        return sprintf(' %s%s=\'%s\'', $this->isVBind($value) ? 'v-bind:' : '', $attribute, $this->getJsPropValue($value));
    }

    /**
     * Checks if we need to add 'v-bind:' before the prop declaration.
     *
     * @param mixed $value
     * @return boolean
     */
    protected function isVBind($value)
    {
        return ! is_string($value);
    }

    /**
     * Converts the given value to a JS readable and by Vue parseable format.
     *
     * @param mixed $value
     * @return string
     */
    protected function getJsPropValue($value)
    {
        if (is_numeric($value)) {
            $value = (string) $value;
        }

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        return $value;
    }
}