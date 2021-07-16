<?php

namespace Whitecube\LaravelFlexibleContent\Concerns;

use Whitecube\LaravelFlexibleContent\LayoutsCollection;
use Whitecube\LaravelFlexibleContent\Contracts\Flexible;
use Whitecube\LaravelFlexibleContent\Exceptions\LayoutNotFoundException;

trait HasLayoutInstances
{
    /**
     * The resolved layout instances (the Flexible container's value)
     *
     * @var \Whitecube\LaravelFlexibleContent\LayoutsCollection
     **/
    protected $instances;

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
     * @param null|int $instances
     * @return $this
     */
    public function limit(?int $instances = 1) : Flexible
    {
        $this->limit = (($instances ?? -1) < 0) ? null : $instances;

        return $this;
    }

    /**
     * Retrieve the amount of layouts that can be instanciated in 
     * this Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int
    {
        return $this->limit;
    }

    /**
     * Add a layout instance to the Flexible container.
     *
     * @param string $key
     * @param array $attributes
     * @param null|int $index
     * @param null|string $id
     * @return $this
     */
    public function insert(string $key, array $attributes = [], ?int $index = null, ?string $id = null) : Flexible
    {
        if(! ($layout = $this->getLayout($key))) {
            throw LayoutNotFoundException::make($key);
        }

        $instance = $layout->make($id, $attributes);

        (is_null($index) || $index >= $this->count())
            ? $this->instances()->push($instance)
            : $this->instances()->splice($index, 0, [$instance]);

        return $this;
    }

    /**
     * Get all the inserted layout instances as a collection.
     *
     * @return \Whitecube\LaravelFlexibleContent\LayoutsCollection
     */
    public function instances() : LayoutsCollection
    {
        if(! $this->instances) {
            $this->instances = new LayoutsCollection();
        }

        return $this->instances;
    }

    /**
     * Get the amount of inserted layout instances, total or per layout key.
     *
     * @param null|string $key
     * @return int
     */
    public function count(?string $key = null)
    {
        if(! $this->instances) {
            return 0;
        }

        return is_null($key)
            ? $this->instances->count()
            : $this->instances->whereKey($key)->count();
    }
}
