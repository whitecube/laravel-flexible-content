<?php

namespace Whitecube\LaravelFlexibleContent\Contracts;

interface Layout
{
    /**
     * Define the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int;
}
