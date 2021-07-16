<?php

namespace Whitecube\LaravelFlexibleContent\Contracts;

interface Flexible
{
    /**
     * Prevent the Flexible container to instanciate more layouts
     * than the indicated amount.
     *
     * @param int $instances
     * @return $this
     */
    public function limit($instances = 1) : Flexible;
}
