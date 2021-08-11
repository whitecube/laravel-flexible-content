<?php

namespace Whitecube\LaravelFlexibleContent\Concerns;

use Illuminate\Support\Collection;
use Whitecube\LaravelFlexibleContent\Contracts\Layout;
use Whitecube\LaravelFlexibleContent\Exceptions\InvalidSerializationFormatException;

trait HasResolver
{
    /**
     * The callback to be used to setup the Flexible container's value.
     *
     * @var null|callable
     */
    public $buildCallback;

    /**
     * The callback to be used when saving the Flexible container's value.
     *
     * @var null|callable
     */
    public $serializeCallback;

    /**
     * The value serialization method.
     * Available methods are: json, array, collection
     *
     * @var string
     */
    protected $serializeFormat = 'json';

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
     * Define the callback that should be used when saving the Flexible container's value.
     *
     * @param callable $saveCallback
     * @return $this
     */
    public function serializeUsing(callable $serializeCallback)
    {
        $this->serializeCallback = $serializeCallback;

        return $this;
    }

    /**
     * Define a default serialization format method that should be used when saving the Flexible container's value.
     *
     * @param string $serializeFormat
     * @return $this
     */
    public function serializeUsingFormat(string $serializeFormat)
    {
        $this->serializeFormat = $serializeFormat;

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
     * @return mixed
     */
    public function serialize()
    {
        if(! is_null($this->serializeCallback)) {
            return call_user_func($this->serializeCallback, $this);
        }

        return $this->serializeAs($this->serializeFormat);
    }

    /**
     * Transform the current value in the desired format.
     *
     * @param string $format
     * @return mixed
     */
    public function serializeAs(string $format)
    {
        $serializationMethod = 'serializeAs' . ucfirst($format);

        if(! method_exists($this, $serializationMethod)) {
            throw InvalidSerializationFormatException::make($format);
        }

        return $this->$serializationMethod();
    }

    /**
     * Transform the current value into a serialized array.
     *
     * @return array
     */
    public function serializeAsArray()
    {
        return $this->instances()
            ->map(fn(Layout $instance) => [
                'key' => $instance->getKey(),
                'id' => $instance->getId(),
                'attributes' => $instance->getAttributes()
            ])
            ->all();
    }

    /**
     * Transform the current value into a serialized JSON string.
     *
     * @return string
     */
    public function serializeAsJson()
    {
        return json_encode($this->serializeAsArray());
    }

    /**
     * Transform the current value into a serialized collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function serializeAsCollection()
    {
        return collect($this->serializeAsArray());
    }
}
