<?php

namespace mrcrmn\VueGenerator;

use mrcrmn\VueGenerator\Vue;
use mrcrmn\VueGenerator\Renderable;

class VueCollection implements Renderable
{
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
     * Adds one or more Renderable components to the collection.
     *
     * @param array|Renderable $vue
     * @return $this
     */
    public function add($vue)
    {
        if (is_array($vue)) {
            foreach ($vue as $component) {
                $this->add($component);
            }
        } else {
            if (! $vue instanceof Renderable) {
                throw new \Exception("This object cannot be added to this collection. Make sure it implements the Renderable Interface.");
            }
    
            $this->items[] = $vue;
        }

        return $this;
    }

    /**
     * Renders all components in the collection.
     *
     * @return string
     */
    public function render()
    {
        $output = '';

        foreach ($this->items as $renderable)
        {
            $output .= $renderable->render();
        }

        return $output;
    }
}