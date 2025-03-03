<?php

namespace Whitecube\LaravelFlexibleContent;

use Illuminate\Support\Collection;

class LayoutsCollection extends Collection
{
    /**
     * Find a layout or layout instance based on its key.
     *
     * @return null|\Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function find(string $key)
    {
        return $this->first(function ($layout) use ($key) {
            return $layout->getKey() === $key;
        });
    }

    /**
     * Find layouts or layout instances based on their key.
     *
     * @return \Whitecube\LaravelFlexibleContent\LayoutsCollection
     */
    public function whereKey(string $key)
    {
        return $this->filter(function ($layout) use ($key) {
            return $layout->getKey() === $key;
        });
    }

    /**
     * Find layouts or layout instances where key is different from the provided one.
     *
     * @return \Whitecube\LaravelFlexibleContent\LayoutsCollection
     */
    public function whereKeyNot(string $key)
    {
        return $this->filter(function ($layout) use ($key) {
            return $layout->getKey() !== $key;
        });
    }

    /**
     * Find layouts or layout instances with keys contained in the provided array.
     *
     * @return \Whitecube\LaravelFlexibleContent\LayoutsCollection
     */
    public function whereKeyIn(array $keys)
    {
        return $this->filter(function ($layout) use ($keys) {
            return in_array($layout->getKey(), $keys);
        });
    }

    /**
     * Find layouts or layout instances with keys not contained in the provided array.
     *
     * @return \Whitecube\LaravelFlexibleContent\LayoutsCollection
     */
    public function whereKeyNotIn(array $keys)
    {
        return $this->filter(function ($layout) use ($keys) {
            return ! in_array($layout->getKey(), $keys);
        });
    }
}
