<?php

namespace Whitecube\LaravelFlexibleContent\Contracts;

interface Layout
{
    /**
     * Define the layout's unique key.
     *
     * @param string $key
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function key(string $key) : Layout;

    /**
     * Retrieve the layout's unique key.
     *
     * @return null|string
     */
    public function getKey() : ?string;

    /**
     * Define the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @param null|int $instances
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function limit(int $instances = null) : Layout;

    /**
     * Retrieve the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int;
}
