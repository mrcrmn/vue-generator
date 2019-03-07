<?php

namespace mrcrmn\VueGenerator;

use mrcrmn\VueGenerator\Renderable;

class HtmlTag implements Renderable
{
    /**
     * The name of the Html Tag.
     *
     * @var string
     */
    protected $tag;

    /**
     * The HTML tags attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The tags content.
     *
     * @var string
     */
    protected $slot;

    /**
     * The array of self closing tags.
     *
     * @param array $tag
     */
    protected $selfClosingTags = [
        'img', 'input', 'br', 'hr', 'link', 'meta', 'area', 'base', 'col', 'embed', 'param', 'source', 'track', 'wbr'
    ];

    /**
     * Constructs the Tag.
     *
     * @param string $tag The tag name.
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Static constructor.
     *
     * @return $this
     */
    public static function make()
    {
        return new static(...func_get_args());
    }

    /**
     * Gets the tag name.
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->tag;   
    }

    /**
     * Renders the tag name.
     *
     * @param string $input
     * @return string
     */
    protected function renderTag($input)
    {
        return str_replace('{{TAG}}', $this->getTagName(), $input);
    }

    /**
     * Checks if the attributes array is empty.
     *
     * @return boolean
     */
    protected function hasAttributes()
    {
        return ! empty($this->attributes);
    }

    /**
     * Returns the string representation for the HTML attribute.
     *
     * @return string
     */
    protected function getRenderableAttributes()
    {
        $return = '';

        foreach ($this->attributes as $attribute => $value) {
            $return .= $this->getSingleAttribute($attribute, $value);
        }

        return $return;
    }

    /**
     * Gets a single attribute value combo for the html tag.
     *
     * @param string $attribute
     * @param string|mixed $value
     * @return void
     */
    protected function getSingleAttribute($attribute, $value)
    {
        return sprintf(' %s="%s"', $attribute, $value);
    }

    /**
     * Renders the tags content.
     *
     * @param string $input
     * @return string
     */
    protected function renderSlot($input)
    {
        return str_replace('{{SLOT}}', $this->getSlot(), $input);
    }

    /**
     * Renders the attributes.
     *
     * @param string $input
     * @return string
     */
    protected function renderAttributes($input)
    {
        $render = $this->hasAttributes()
            ? $this->getRenderableAttributes()
            : '';

        return str_replace('{{ATTRIBUTES}}', $render, $input);
    }

    /**
     * Renders the full HTML.
     *
     * @return string
     */
    public function render()
    {
        $output = '<{{TAG}}{{ATTRIBUTES}}>' . ($this->isSelfClosing() ? '' : '{{SLOT}}</{{TAG}}>');

        $output = $this->renderTag($output);
        $output = $this->renderAttributes($output);
        $output = $this->renderSlot($output);

        return $output;
    }

    /**
     * The toString representation returns the rendered HTML.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Checks if the current tag is a self closing tag.
     *
     * @return boolean
     */
    protected function isSelfClosing()
    {
        return in_array($this->getTagName(), $this->selfClosingTags);
    }

    /**
     * Sets an HTML attribute.
     *
     * @param string|array $attribute
     * @param string|null $value
     * @param boolean $boolean
     * @return $this
     */
    public function setAttribute($attribute, $value = null, $boolean = true)
    {
        if (! is_array($attribute)) {
            $attribute = [$attribute => $value];
        } else {
            $boolean = is_bool($value) ? $value : true;
        }

        if ($boolean) {
            array_walk($attribute, function($value, $key) {
                $this->attributes[$key] = $value;
            });
        }

        return $this;
    }

    /**
     * The the tags content aka. slot.
     *
     * @param string $slot
     * @return $this
     */
    public function setSlot($slot = '')
    {
        $this->slot = $slot;

        return $this;
    }

    /**
     * Getter for the slot.
     *
     * If the slot is an instance of Renderable, the rendered output will be returned.
     * 
     * @return string
     */
    public function getSlot()
    {
        if ($this->slot instanceof Renderable) {
            return $this->slot->render();
        }

        return $this->slot;
    }
}