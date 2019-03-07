<?php

namespace mrcrmn\VueGenerator\Traits;

trait ArrayAccessable
{
    /**
     * Gets a value by a given key.
     *
     * @param string|int $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }
    /**
     * Sets the value by a given key.
     *
     * @param string|int $key
     * @param mixed $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }
    /**
     * Checks if the given key exists.
     *
     * @param string|int $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }
    /**
     * Unsets the given key.
     *
     * @param string|int $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Counts all items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}