<?php

namespace Whitecube\LaravelFlexibleContent\Concerns;

use Whitecube\LaravelFlexibleContent\Layout as BaseLayout;
use Whitecube\LaravelFlexibleContent\LayoutsCollection;
use Whitecube\LaravelFlexibleContent\Contracts\Flexible;
use Whitecube\LaravelFlexibleContent\Contracts\Layout;
use Whitecube\LaravelFlexibleContent\Exceptions\InvalidLayoutException;
use Whitecube\LaravelFlexibleContent\Exceptions\InvalidLayoutKeyException;

trait HasLayouts
{
    /**
     * The defined instanciable layouts
     *
     * @var \Whitecube\LaravelFlexibleContent\LayoutsCollection
     **/
    protected $layouts;

    /**
     * Add an instanciable layout to the Flexible container.
     *
     * @param mixed $layout
     * @param null|int $limit
     * @return $this
     */
    public function register($layout, int $limit = null) : Flexible
    {
        if(is_string($layout) && is_a($layout, Layout::class, true)) {
            $layout = new $layout;
        } elseif (is_callable($layout)) {
            $layout = call_user_func($layout, ($instance = new BaseLayout)) ?? $instance;
        }

        if(! is_a($layout, Layout::class)) {
            throw InvalidLayoutException::make($layout);
        }

        if(! ($key = $layout->getKey())) {
            throw InvalidLayoutKeyException::make($layout);
        }

        if($this->hasLayout($key)) {
            throw InvalidLayoutKeyException::make($layout, $key, true);
        }

        if(! is_null($limit)) {
            $layout->limit($limit);
        }

        $this->layouts()->put($key, $layout);

        return $this;
    }

    /**
     * Check if the Flexible container has a defined layout for given key.
     *
     * @param string $key
     * @return bool
     */
    public function hasLayout(string $key) : bool
    {
        return $this->layouts ? $this->layouts->has($key) : false;
    }

    /**
     * Get the defined layout for given key in the Flexible container.
     *
     * @param string $key
     * @return null|\Whitecube\LaravelFlexibleContent\Contracts\Layout
     */
    public function getLayout(string $key) : ?Layout
    {
        return $this->layouts ? $this->layouts->get($key) : null;
    }

    /**
     * Get all the defined layouts as a collection.
     *
     * @return \Whitecube\LaravelFlexibleContent\LayoutsCollection
     */
    public function layouts() : LayoutsCollection
    {
        if(! $this->layouts) {
            $this->layouts = new LayoutsCollection();
        }

        return $this->layouts;
    }

    /**
     * Get all the defined layouts serialized for display in a menu.
     *
     * @return array
     */
    public function layoutsMenu() : array
    {
        return $this->layouts()
            ->map(fn(Layout $layout) => $layout->toButtonArray())
            ->values()
            ->all();
    }
}
