<?php

namespace mrcrmn\VueGenerator\Traits;

trait CanBeIterated
{
    /**
     * The current position of the iterator.
     *
     * @var int
     */
    protected $position = 0;

    /**
     * Resets the current position.
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Returns the current positions value.
     *
     * @return mixed
     */
    public function current()
    {
        return $this->offsetGet($this->position);
    }

    /**
     * Returns the current iterator position.
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Increments the current iterator position.
     *
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Checks if the current iterator position is valid.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->offsetExists($this->position);
    }
}