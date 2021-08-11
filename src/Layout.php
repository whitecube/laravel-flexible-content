<?php

namespace Whitecube\LaravelFlexibleContent;

use ArrayAccess;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HidesAttributes;
use Whitecube\LaravelFlexibleContent\Contracts\Layout as LayoutInterface;

class Layout implements LayoutInterface, ArrayAccess
{
    use HasAttributes;
    use HidesAttributes;

    /**
     * A short unique name for this Layout, usually used by front-end components
     *
     * @var string
     **/
    protected $key;

    /**
     * An unique and immutable identifier for this instance
     *
     * @var string
     **/
    protected $id;

    /**
     * The max. amount of instances of this layout a Flexible may contain
     *
     * @var null|int
     **/
    protected $limit;

    /**
     * Define the layout's unique key (layout name).
     *
     * @param string $key
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function key(string $key) : LayoutInterface
    {
        $this->key = trim($key);

        return $this;
    }

    /**
     * Retrieve the layout's unique key.
     *
     * @return null|string
     */
    public function getKey() : ?string
    {
        return $this->key;
    }

    /**
     * Define the layout instance's unique and immutable identifier.
     *
     * @param string $id
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function id(string $id) : LayoutInterface
    {
        if(! is_null($this->id)) {
            return $this;
        }

        $this->id = trim($id);

        return $this;
    }

    /**
     * Retrieve the layout instance's unique identifier.
     *
     * @return null|string
     */
    public function getId() : ?string
    {
        return $this->id;
    }

    /**
     * Define the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @param null|int $instances
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function limit(?int $instances = 1) : LayoutInterface
    {
        $this->limit = (($instances ?? -1) < 0) ? null : $instances;

        return $this;
    }

    /**
     * Retrieve the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int
    {
        return $this->limit;
    }

    /**
     * Set the array of layout instance attributes. No checking is done.
     *
     * @param array $attributes
     * @param bool $syncOriginal
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function attributes(array $attributes, $syncOriginal = false): LayoutInterface
    {
        $this->setRawAttributes($attributes, $syncOriginal);

        return $this;
    }

    /**
     * Create a layout instance from this layout.
     *
     * @param int $instances
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function make(?string $id = null, array $attributes = []) : LayoutInterface
    {
        return (new static())
            ->key($this->key)
            ->id($id ?? Str::uuid())
            ->attributes($attributes, true)
            ->limit($this->limit);
    }

    /**
     * Get the value indicating whether the IDs are incrementing (they are not since this is not a model).
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Determine if the layout uses timestamps (it doesn't since this is not a model).
     *
     * @return bool
     */
    public function usesTimestamps()
    {
        return false;
    }

    /**
     * Check if relation exists (it doesn't since this is not a model).
     *
     * @return bool
     */
    protected function relationLoaded()
    {
        return false;
    }

    /**
     * Dynamically retrieve attributes on the layout.
     *
     * @param string $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }

    /**
     * Dynamically set attributes on the layout.
     *
     * @param string $attribute
     * @param mixed $value
     * @return void
     */
    public function __set($attribute, $value)
    {
        $this->setAttribute($attribute, $value);
    }

    /**
     * Determine if an attribute exists on the layout.
     *
     * @param string $attribute
     * @return bool
     */
    public function __isset($attribute)
    {
        return $this->offsetExists($attribute);
    }

    /**
     * Unset an attribute on the layout.
     *
     * @param string $attribute
     * @return void
     */
    public function __unset($attribute)
    {
        $this->offsetUnset($attribute);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param mixed $attribute
     * @return bool
     */
    public function offsetExists($attribute)
    {
        return ! is_null($this->getAttribute($attribute));
    }

    /**
     * Get the value for a given offset.
     *
     * @param mixed $attribute
     * @return mixed
     */
    public function offsetGet($attribute)
    {
        return $this->getAttribute($attribute);
    }

    /**
     * Set the value for a given offset.
     *
     * @param mixed $attribute
     * @param mixed $value
     * @return void
     */
    public function offsetSet($attribute, $value)
    {
        $this->setAttribute($attribute, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param mixed $attribute
     * @return void
     */
    public function offsetUnset($attribute)
    {
        unset($this->attributes[$attribute]);
    }
}
