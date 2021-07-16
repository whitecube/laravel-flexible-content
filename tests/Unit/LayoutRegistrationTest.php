<?php

namespace Tests\Unit;

use Whitecube\LaravelFlexibleContent\Flexible;
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
