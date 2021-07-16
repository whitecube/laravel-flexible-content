<?php

namespace Whitecube\LaravelFlexibleContent\Contracts;

use Whitecube\LaravelFlexibleContent\LayoutsCollection;
use Whitecube\LaravelFlexibleContent\Contracts\Layout;

interface Flexible
{
    /**
     * Add an instanciable layout to the Flexible container.
     *
     * @param mixed $layout
     * @param null|int $limit
     * @return $this
     */
    public function register($layout, int $limit = null) : Flexible;

    /**
     * Check if the Flexible container has a defined layout for given key.
     *
     * @param string $key
     * @return bool
     */
    public function hasLayout(string $key) : bool;

    /**
     * Get the defined layout for given key in the Flexible container.
     *
     * @param string $key
     * @return null|\Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function getLayout(string $key) : ?Layout;

    /**
     * Get all the defined layouts as a collection.
     *
     * @return \Whitecube\LaravelFlexibleContent\LayoutsCollection
     */
    public function layouts() : LayoutsCollection;

    /**
     * Prevent the Flexible container to instanciate more layouts
     * than the indicated amount.
     *
     * @param null|int $instances
     * @return $this
     */
    public function limit(?int $instances = 1) : Flexible;

    /**
     * Retrieve the amount of layouts that can be instanciated in 
     * this Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int;

    /**
     * Add a layout instance to the Flexible container.
     *
     * @param string $key
     * @param array $attributes
     * @param null|int $index
     * @param null|string $id
     * @return $this
     */
    public function insert(string $key, array $attributes = [], ?int $index = null, ?string $id = null) : Flexible;

    /**
     * Get all the inserted layout instances as a collection.
     *
     * @return \Whitecube\LaravelFlexibleContent\LayoutsCollection
     */
    public function instances() : LayoutsCollection;

    /**
     * Get the amount of inserted layout instances, total or per layout key.
     *
     * @param null|string $key
     * @return int
     */
    public function count(?string $key = null);
}
