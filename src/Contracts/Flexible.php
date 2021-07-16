<?php

namespace Whitecube\LaravelFlexibleContent\Contracts;

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
     * Prevent the Flexible container to instanciate more layouts
     * than the indicated amount.
     *
     * @param int $instances
     * @return $this
     */
    public function limit(int $instances = 1) : Flexible;

    /**
     * Retrieve the amount of layouts that can be instanciated in 
     * this Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int;
}
