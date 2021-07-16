<?php

namespace Whitecube\LaravelFlexibleContent\Concerns;

use Whitecube\LaravelFlexibleContent\Contracts\Flexible;

trait HasLayoutInstances
{
    /**
     * The max. amount of instances this Flexible may contain.
     *
     * @var null|int
     **/
    protected $limit;

    /**
     * Prevent the Flexible container to instanciate more layouts
     * than the indicated amount.
     *
     * @param int $instances
     * @return $this
     */
    public function limit(int $instances = 1) : Flexible
    {
        $this->limit = ($instances < 0) ? null : $instances;

        return $this;
    }
}
