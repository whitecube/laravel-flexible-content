<?php

namespace Whitecube\LaravelFlexibleContent\Contracts;

use Whitecube\LaravelFlexibleContent\LayoutsCollection;

interface Flexible
{
    /**
     * Add an instanciable layout to the Flexible container.
     *
     * @param  mixed  $layout
     * @return $this
     */
    public function register(string|Layout|callable $layout, ?int $limit = null): Flexible;

    /**
     * Check if the Flexible container has a defined layout for given key.
     */
    public function hasLayout(string $key): bool;

    /**
     * Get the defined layout for given key in the Flexible container.
     */
    public function getLayout(string $key): ?Layout;

    /**
     * Get all the defined layouts as a collection.
     */
    public function layouts(): LayoutsCollection;

    /**
     * Get all the defined layouts serialized for display in a menu.
     */
    public function layoutsMenu(): array;

    /**
     * Prevent the Flexible container to instanciate more layouts
     * than the indicated amount.
     *
     * @return $this
     */
    public function limit(?int $instances = 1): Flexible;

    /**
     * Retrieve the amount of layouts that can be instanciated in
     * this Flexible container.
     */
    public function getLimit(): ?int;

    /**
     * Add a layout instance to the Flexible container.
     *
     * @return $this
     */
    public function insert(string $key, array $attributes = [], ?int $index = null, ?string $id = null): Flexible;

    /**
     * Get all the inserted layout instances as a collection.
     */
    public function instances(): LayoutsCollection;

    /**
     * Get all the inserted layout instances serialized for display in a user interface.
     */
    public function instancesValues(): array;

    /**
     * Get the amount of inserted layout instances, total or per layout key.
     */
    public function count(?string $key = null): int;
}
