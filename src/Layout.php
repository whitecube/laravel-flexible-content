<?php

namespace Whitecube\LaravelFlexibleContent;

use Whitecube\LaravelFlexibleContent\Contracts\Layout as LayoutInterface;

abstract class Layout implements LayoutInterface
{
    /**
     * The max. amount of instances of this layout a Flexible may contain
     *
     * @var null|int
     **/
    protected $limit;

    /**
     * Define the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int
    {
        return $this->limit;
    }
}
