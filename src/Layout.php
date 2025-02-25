<?php

namespace Whitecube\LaravelFlexibleContent;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HidesAttributes;
use Illuminate\Support\Str;
use JsonSerializable;
use Whitecube\LaravelFlexibleContent\Contracts\Flexible as FlexibleInterface;
use Whitecube\LaravelFlexibleContent\Contracts\Layout as LayoutInterface;
use Whitecube\LaravelFlexibleContent\Exceptions\InstanceNotInsertableException;

class Layout implements Arrayable, ArrayAccess, JsonSerializable, LayoutInterface
{
    use HasAttributes;
    use HidesAttributes;

    /**
     * Indicates if the model exists.
     *
     * @var bool
     */
    public $exists = false;

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
     */
    public function key(string $key): LayoutInterface
    {
        $this->key = trim($key);

        return $this;
    }

    /**
     * Retrieve the layout's unique key.
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * Define the layout instance's unique and immutable identifier.
     */
    public function id(string $id): LayoutInterface
    {
        if (! is_null($this->id)) {
            return $this;
        }

        $this->id = trim($id);

        return $this;
    }

    /**
     * Retrieve the layout instance's unique identifier.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Define the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     */
    public function limit(?int $instances = 1): LayoutInterface
    {
        $this->limit = (($instances ?? -1) < 0) ? null : $instances;

        return $this;
    }

    /**
     * Retrieve the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Set the array of layout instance attributes. No checking is done.
     *
     * @param  bool  $syncOriginal
     */
    public function attributes(array $attributes, $syncOriginal = false): LayoutInterface
    {
        $this->setRawAttributes($attributes, $syncOriginal);

        return $this;
    }

    /**
     * Check if the current layout can be inserted in the provided flexible container.
     * If not insertable, it is recommended to return an error code (int).
     *
     * @return bool|int
     */
    public function isInsertable(FlexibleInterface $container)
    {
        if (! is_null($limit = $this->getLimit()) && ($limit <= $container->count($this->getKey()))) {
            return InstanceNotInsertableException::REASON_LAYOUT_LIMIT;
        }

        return true;
    }

    /**
     * Create a layout instance from this layout.
     */
    public function make(?string $id = null, array $attributes = []): LayoutInterface
    {
        return (new static)
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
     * @param  string  $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }

    /**
     * Dynamically set attributes on the layout.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return void
     */
    public function __set($attribute, $value)
    {
        $this->setAttribute($attribute, $value);
    }

    /**
     * Determine if an attribute exists on the layout.
     *
     * @param  string  $attribute
     * @return bool
     */
    public function __isset($attribute)
    {
        return $this->offsetExists($attribute);
    }

    /**
     * Unset an attribute on the layout.
     *
     * @param  string  $attribute
     * @return void
     */
    public function __unset($attribute)
    {
        $this->offsetUnset($attribute);
    }

    /**
     * Determine if the given attribute exists.
     */
    public function offsetExists(mixed $attribute): bool
    {
        return ! is_null($this->getAttribute($attribute));
    }

    /**
     * Get the value for a given offset.
     */
    public function offsetGet(mixed $attribute): mixed
    {
        return $this->getAttribute($attribute);
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $attribute
     * @param  mixed  $value
     */
    public function offsetSet($attribute, $value): void
    {
        $this->setAttribute($attribute, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $attribute
     */
    public function offsetUnset($attribute): void
    {
        unset($this->attributes[$attribute]);
    }

    /**
     * Convert the layout instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributesToArray();
    }

    /**
     * Convert the layout instance's state to an array that can be saved.
     */
    public function toSerializableArray(): array
    {
        return [
            'key' => $this->getKey(),
            'id' => $this->getId(),
            'attributes' => $this->getAttributes(),
        ];
    }

    /**
     * Convert the layout instance's state to an array that can be displayed in an user interface.
     * It is intended to be extended and filled with the frontend component's required attributes.
     */
    public function toDisplayableArray(): array
    {
        return [
            'key' => $this->getKey(),
            'id' => $this->getId(),
        ];
    }

    /**
     * Convert the layout to an array that can be displayed in a user menu.
     * It is intended to be extended and filled with the frontend component's required attributes.
     */
    public function toButtonArray(): array
    {
        return [
            'key' => $this->getKey(),
            'limit' => $this->getLimit(),
        ];
    }

    /**
     * This method is called by the HasAttributes trait, and is usually
     * defined on a model class. In this case, we don't need to handle
     * it, but we do need to have the method to avoid errors.
     */
    public function relationResolver($classname, $key)
    {
        return false;
    }

    /**
     * This method is called by the HasAttributes trait, and is usually
     * defined on a model class. In this case, we don't need to handle
     * it, but we do need to have the method to avoid errors.
     */
    public function preventsAccessingMissingAttributes()
    {
        return false;
    }

    /**
     * Transform layout for front-end serialization (AJAX requests usage).
     */
    public function jsonSerialize(): array
    {
        return array_merge(
            $this->toButtonArray(),
            $this->toSerializableArray()
        );
    }
}
