<?php

namespace Whitecube\LaravelFlexibleContent\Concerns;

use Whitecube\LaravelFlexibleContent\LayoutsCollection;
use Whitecube\LaravelFlexibleContent\Contracts\Layout;
use Whitecube\LaravelFlexibleContent\Contracts\Flexible;
use Whitecube\LaravelFlexibleContent\Exceptions\LayoutNotFoundException;
use Whitecube\LaravelFlexibleContent\Exceptions\InstanceNotInsertableException;

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

        if(($reason = $this->canInsert($instance)) !== true) {
            throw InstanceNotInsertableException::make($instance, $reason);
        }

        (is_null($index) || $index >= $this->count())
            ? $this->instances()->push($instance)
            : $this->instances()->splice($index, 0, [$instance]);

        return $this;
    }

    /**
     * Check if the given instance can be inserted or return the
     * reason for refusal.
     *
     * @param \Whitecube\LaravelFlexibleContent\Contracts\Layout $instance
     * @return bool|int
     */
    protected function canInsert(Layout $instance)
    {
        if(! is_null($limit = $this->getLimit()) && ($limit <= $this->count())) {
            return InstanceNotInsertableException::REASON_LIMIT;
        }

        $code = $instance->isInsertable($this);

        if(is_int($code) || $code === false) {
            return $code ?: 0;
        }

        return true;
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
     * Get all the inserted layout instances serialized for display in a user interface.
     *
     * @return array
     */
    public function instancesValues() : array
    {
        return $this->instances()
            ->map(fn(Layout $instance) => $instance->toDisplayableArray())
            ->values()
            ->all();
    }

    /**
     * Get the amount of inserted layout instances, total or per layout key.
     *
     * @param null|string $key
     * @return int
     */
    public function count(?string $key = null): int
    {
        if(! $this->instances) {
            return 0;
        }

        return is_null($key)
            ? $this->instances->count()
            : $this->instances->whereKey($key)->count();
    }
}
