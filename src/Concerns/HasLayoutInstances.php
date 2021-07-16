<?php

namespace Whitecube\LaravelFlexibleContent\Concerns;

use Whitecube\LaravelFlexibleContent\Contracts\Flexible;
use Whitecube\LaravelFlexibleContent\Exceptions\LayoutNotFoundException;

trait HasLayoutInstances
{
    /**
     * The resolved layout instances (the Flexible container's value)
     *
     * @var array
     **/
    protected $instances = [];

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
     * @return void
     */
    public function insert(string $key, array $attributes = [], ?int $index = null, ?string $id = null)
    {
        if(! ($layout = $this->getLayout($key))) {
            throw LayoutNotFoundException::make($key);
        }

        $instance = $layout->make($id, $attributes);

        if(is_null($index) || $index >= count($this->instances)) {
            $this->instances[] = $instance;
            return;
        }

        array_splice($this->instances, $index, 0, [$instance]);
    }

    /**
     * Get the amount of inserted layout instances, total or per layout key.
     *
     * @param null|string $key
     * @return int
     */
    public function count(?string $key = null)
    {
        if(is_null($key)) {
            return count($this->instances);
        }

        return array_reduce($this->instances, function($count, $instance) use ($key) {
            return ($instance->getKey() === $key) ? ++$count : $count;
        }, 0);
    }
}
