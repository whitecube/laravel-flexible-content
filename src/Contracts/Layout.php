<?php

namespace Whitecube\LaravelFlexibleContent\Contracts;

use Whitecube\LaravelFlexibleContent\Contracts\Flexible;

interface Layout
{
    /**
     * Define the layout's unique key (layout name).
     *
     * @param string $key
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function key(string $key) : Layout;

    /**
     * Retrieve the layout's unique key.
     *
     * @return null|string
     */
    public function getKey() : ?string;

    /**
     * Define the layout instance's unique and immutable identifier.
     *
     * @param string $id
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function id(string $id) : Layout;

    /**
     * Retrieve the layout instance's unique identifier.
     *
     * @return null|string
     */
    public function getId() : ?string;

    /**
     * Define the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @param null|int $instances
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function limit(?int $instances) : Layout;

    /**
     * Retrieve the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     *
     * @return null|int
     */
    public function getLimit() : ?int;

    /**
     * Set the array of layout instance attributes. No checking is done.
     *
     * @param array $attributes
     * @param bool $syncOriginal
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function attributes(array $attributes, $syncOriginal = false) : Layout;

    /**
     * Get all of the current attributes on the layout instance.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Check if the current layout can be inserted in the provided flexible container.
     * If not insertable, it is recommended to return an error code (int).
     *
     * @param \Whitecube\LaravelFlexibleContent\Contracts\Flexible $container
     * @return bool|int
     */
    public function isInsertable(Flexible $container);

    /**
     * Create a layout instance from this layout.
     *
     * @param int $instances
     * @return \Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function make(?string $id = null, array $attributes = []) : Layout;
}
