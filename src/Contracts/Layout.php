<?php

namespace Whitecube\LaravelFlexibleContent\Contracts;

interface Layout
{
    /**
     * Define the layout's unique key (layout name).
     */
    public function key(string $key): Layout;

    /**
     * Retrieve the layout's unique key.
     */
    public function getKey(): ?string;

    /**
     * Define the layout instance's unique and immutable identifier.
     */
    public function id(string $id): Layout;

    /**
     * Retrieve the layout instance's unique identifier.
     */
    public function getId(): ?string;

    /**
     * Define the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     */
    public function limit(?int $instances): Layout;

    /**
     * Retrieve the amount of layouts of this kind that can be
     * instanciated in a Flexible container.
     */
    public function getLimit(): ?int;

    /**
     * Set the array of layout instance attributes. No checking is done.
     *
     * @param  bool  $syncOriginal
     */
    public function attributes(array $attributes, $syncOriginal = false): Layout;

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
     * @return bool|int
     */
    public function isInsertable(Flexible $container);

    /**
     * Create a layout instance from this layout.
     *
     * @param  int  $instances
     */
    public function make(?string $id = null, array $attributes = []): Layout;

    /**
     * Convert the layout instance's state to an array that can be saved.
     */
    public function toSerializableArray(): array;

    /**
     * Convert the layout instance's state to an array that can be displayed in an user interface.
     * It is intended to be extended and filled with the frontend component's required attributes.
     */
    public function toDisplayableArray(): array;

    /**
     * Convert the layout to an array that can be displayed in a user menu.
     * It is intended to be extended and filled with the frontend component's required attributes.
     */
    public function toButtonArray(): array;
}
