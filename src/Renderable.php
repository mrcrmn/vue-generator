<?php

namespace mrcrmn\VueGenerator;

interface Renderable
{
    /**
     * Renders the component
     *
     * @return string
     */
    public function render();
}