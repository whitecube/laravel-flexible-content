<?php

namespace Whitecube\LaravelFlexibleContent\Concerns;

use Illuminate\Support\Collection;

trait HasResolver
{
    /**
     * The callback to be used to setup the Flexible container's value.
     *
     * @var null|callable
     */
    public $buildCallback;

    /**
     * The callback to be used to save the Flexible container's value.
     *
     * @var null|callable
     */
    public $saveCallback;

    /**
     * Define the callback that should be used to setup the Flexible container's value.
     *
     * @param callable $buildCallback
     * @return $this
     */
    public function buildUsing(callable $buildCallback)
    {
        $this->buildCallback = $buildCallback;

        return $this;
    }

    /**
     * Define the callback that should be used to save the Flexible container's value.
     *
     * @param callable $saveCallback
     * @return $this
     */
    public function saveUsing(callable $saveCallback)
    {
        $this->saveCallback = $saveCallback;

        return $this;
    }

    /**
     * Create the Flexible container's base layout instances.
     *
     * @param mixed $data
     * @return $this
     */
    public function build($data = null)
    {
        if(! is_null($this->buildCallback)) {
            call_user_func($this->buildCallback, $this, $data);
            return $this;
        }

        return $this->buildFromData($data);
    }

    /**
     * Create the Flexible container's base layout instances from given value.
     *
     * @param mixed $data
     * @return $this
     */
    public function buildFromData($data = null)
    {
        if($data instanceof Collection) {
            $data = $data->toArray();
        } else if (is_string($data)) {
            $data = json_decode($data, true) ?? [];
        }

        if(! $data || ! is_array($data)) {
            return $this;
        }

        foreach ($data as $item) {
            $this->buildItem($item);
        }

        return $this;
    }

    /**
     * Attempt to insert a single instance from serialized value.
     *
     * @param mixed $item
     * @return $this
     */
    public function buildItem($item)
    {
        if(! is_array($item) && ! is_object($item)) {
            return $this;
        }

        $key = data_get($item, 'key');
        $id = data_get($item, 'id');
        $attributes = data_get($item, 'attributes', []);

        $this->insert($key, (array) $attributes, null, $id ? strval($id) : null);

        return $this;
    }

    /**
     * Execute what has to be done in order to save the current value for next build.
     *
     * @return $this
     */
    public function save()
    {
        // TODO.
        return $this;
    }
}
