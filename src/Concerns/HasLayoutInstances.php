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
     * @param bool|int $instances
     * @return $this
     */
    public function limit($instances = 1) : Flexible
    {
        if(! $instances || $instances < 0) {
            $this->limit = null;
        } else {
            $this->limit = is_int($instances) ? $instances : 1;
        }
        
        return $this;
    }
}
