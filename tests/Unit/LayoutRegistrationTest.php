<?php

namespace Tests\Unit;

use Whitecube\LaravelFlexibleContent\Flexible;
use Whitecube\LaravelFlexibleContent\LayoutsCollection;
use Whitecube\LaravelFlexibleContent\Exceptions\InvalidLayoutException;
use Whitecube\LaravelFlexibleContent\Exceptions\InvalidLayoutKeyException;
use Tests\Fixtures\CustomLayout;

it('can register and configure a basic layout using a closure as argument', function() {
    $flexible = new Flexible();

    $flexible->register(function($layout) {
        $layout->key('foo');
    });

    expect($flexible->hasLayout('foo'))->toBeTrue();
    expect($flexible->hasLayout('bar'))->toBeFalse();
});

it('can register a custom layout using its classname as argument', function() {
    $flexible = new Flexible();

    $flexible->register(CustomLayout::class);

    expect($flexible->hasLayout('custom'))->toBeTrue();
    expect($flexible->hasLayout('foo'))->toBeFalse();
});

it('can register a custom layout using its instance as argument', function() {
    $flexible = new Flexible();

    $layout = new CustomLayout();

    $flexible->register($layout);

    expect($flexible->hasLayout('custom'))->toBeTrue();
    expect($flexible->hasLayout('foo'))->toBeFalse();
});

it('cannot register an argument returned by a configuration closure that does not implement the Layout interface', function() {
    $flexible = new Flexible();

    $flexible->register(function($layout) {
        return true;
    });
})->throws(InvalidLayoutException::class);

it('cannot register a classname that does not implement the Layout interface', function() {
    $flexible = new Flexible();

    $flexible->register(Flexible::class);
})->throws(InvalidLayoutException::class);

it('cannot register an instance that does not implement the Layout interface', function() {
    $flexible = new Flexible();

    $flexible->register(new Flexible());
})->throws(InvalidLayoutException::class);

it('cannot register a layout without defined key', function() {
    $flexible = new Flexible();

    $flexible->register(function($layout) {
        // Not defining a key...
    });
})->throws(InvalidLayoutKeyException::class);

it('cannot register the same layout key twice', function() {
    $flexible = new Flexible();

    $flexible->register(function($layout) {
        $layout->key('custom');
    });

    $flexible->register(CustomLayout::class);
})->throws(InvalidLayoutKeyException::class);

it('can return all registered layouts as a LayoutsCollection', function() {
    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'));

    $collection = $flexible->layouts();

    expect($collection)->toBeInstanceOf(LayoutsCollection::class);
    expect($collection->keys()->implode(','))->toBe('foo,bar');
});

it('can return all registered layouts as a "menu" array', function() {
    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo')->limit(3))
        ->register(fn ($layout) => $layout->key('bar')->limit(4));

    $menu = $flexible->layoutsMenu();

    expect($menu)->toBeArray();
    expect($menu)->toHaveCount(2);
    expect(array_key_exists('id', $menu[0]))->toBeFalse();
    expect(array_key_exists('limit', $menu[0]))->toBeTrue();
});
