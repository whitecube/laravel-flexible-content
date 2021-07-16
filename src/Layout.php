<?php

namespace Whitecube\LaravelFlexibleContent;

use Whitecube\LaravelFlexibleContent\Contracts\Layout as LayoutInterface;

class Layout implements LayoutInterface
{
    /**
     * A short unique identifier for this Layout, usually used by front-end components
     *
     * @var string
     **/
    protected $key;

    /**
     * The max. amount of instances of this layout a Flexible may contain
     *
     * @var null|int
     **/
    protected $limit;

    /**
     * Define the layout's unique key.
     *
     * @param string $key
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function key(string $key) : LayoutInterface
    {
        $this->key = trim($key);

        return $this;
    }

    /**
     * Retrieve the layout's unique key.
     *
     * @return null|string
     */
    public function getKey() : ?string
    {
        return $this->key;
    }

    /**
     * Define the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @param null|int $instances
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function limit(int $instances = null) : LayoutInterface
    {
        $this->limit = $instances;

        return $this;
    }

    /**
     * Retrieve the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int
    {
        return $this->limit;
    }
}
