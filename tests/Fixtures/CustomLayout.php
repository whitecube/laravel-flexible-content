<?php

namespace Tests\Fixtures;

use Whitecube\LaravelFlexibleContent\Layout;

class CustomLayout extends Layout
{
    /**
     * A short unique identifier for this Layout, usually used by front-end components
     *
     * @var string
     **/
    protected $key = 'custom';

    /**
     * The max. amount of instances of this layout a Flexible may contain
     *
     * @var null|int
     **/
    protected $limit = 1;
}