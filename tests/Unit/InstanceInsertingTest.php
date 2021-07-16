<?php

namespace Tests\Unit;

use Whitecube\LaravelFlexibleContent\Flexible;
use Whitecube\LaravelFlexibleContent\Exceptions\LayoutNotFoundException;

it('can push a new empty layout instance to its value', function() {
    $flexible = (new Flexible())->register(function($layout) {
        $layout->key('foo');
    });

    $flexible->insert('foo');

    expect($flexible->count())->toBe(1);
});

it('can push a layout instance with defined attributes to its value', function() {
    $flexible = (new Flexible())->register(function($layout) {
        $layout->key('foo');
    });

    $flexible->insert('foo', ['bar' => 'test'], null, 'some-id');

    expect($flexible->count())->toBe(1);
});

it('can insert a layout at a certain index in its value', function() {
    $flexible = (new Flexible())->register(function($layout) {
        $layout->key('foo');
    });

    $flexible->insert('foo', [], null, 'one');
    $flexible->insert('foo', [], null, 'three');
    $flexible->insert('foo', [], 1, 'two');

    expect($flexible->count())->toBe(3);
    expect($flexible->instances()->map(fn ($layout) => $layout->getId())->implode(','))->toBe('one,two,three');
});

it('cannot add an unregistered layout key to its value', function() {
    $flexible = (new Flexible())->register(function($layout) {
        $layout->key('foo');
    });

    $flexible->insert('bar');
})->throws(LayoutNotFoundException::class);
