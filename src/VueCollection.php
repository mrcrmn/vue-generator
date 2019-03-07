<?php

namespace mrcrmn\VueGenerator;

use mrcrmn\VueGenerator\Vue;
use mrcrmn\VueGenerator\Renderable;
use mrcrmn\VueGenerator\Traits\CanBeIterated;
use mrcrmn\VueGenerator\Traits\ArrayAccessable;

class VueCollection implements Renderable, \ArrayAccess, \Countable, \Iterator
{
    use ArrayAccessable, CanBeIterated;

    /**
     * The Vue objects in this collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Constructs a new Vue Collection.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->add($items);
    }

    /**
     * Throws an exception if the given item doesn't implement the Renderable interface.
     *
     * @param mixed $item
     * @return void
     */
    protected function guard($item)
    {
        if (! $item instanceof Renderable) {
            throw new \InvalidArgumentException("This item cannot be added to this collection. Make sure it implements the Renderable Interface.");
        }
    }

    /**
     * Adds one or more Renderable components to the collection.
     *
     * @param array|Renderable $vue
     * @return $this
     */
    public function add($vue)
    {
        // Wrap a single component in an array.
        $vue = is_array($vue) ? $vue : [$vue];

        array_walk($vue, function($item) {
            $this->guard($item);

            $this->items[] = $item;
        });

        return $this;
    }

    /**
     * Renders all components in the collection.
     *
     * @return string
     */
    public function render()
    {
        return array_reduce($this->items, function($output, $vue) {
            return $output .= $vue->render();
        });
    }
}