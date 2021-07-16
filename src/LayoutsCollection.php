<?php

namespace Whitecube\LaravelFlexibleContent;

use Illuminate\Support\Collection;

class LayoutsCollection extends Collection
{
    /**
     * Find a layout or layout instance based on its key
     *
     * @param string $key
     * @return null|\Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function find(string $key)
    {
        return $this->first(function($layout) use ($key) {
            return $layout->getKey() === $key;
        });
    }
}
