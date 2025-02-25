<?php

namespace Tests\Unit;

use Whitecube\LaravelFlexibleContent\Contracts\Layout;
use Whitecube\LaravelFlexibleContent\Flexible;
use Whitecube\LaravelFlexibleContent\LayoutsCollection;

it('can find a layout by its key', function () {
    $collection = (new Flexible)
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->register(fn ($layout) => $layout->key('baz'))
        ->layouts();

    $layout = $collection->find('bar');

    expect($layout)->toBeInstanceOf(Layout::class);
    expect($layout->getKey())->toBe('bar');
});

it('can find multiple layouts by their key', function () {
    $collection = (new Flexible)
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->insert('foo')
        ->insert('bar')
        ->insert('foo')
        ->insert('bar')
        ->insert('foo')
        ->instances();

    $bar = $collection->whereKey('bar');

    expect($bar)->toBeInstanceOf(LayoutsCollection::class);
    expect($bar->count())->toBe(2);

    $baz = $collection->whereKey('baz');

    expect($baz)->toBeInstanceOf(LayoutsCollection::class);
    expect($baz->isEmpty())->toBeTrue();
});

it('can find multiple layouts with a different key', function () {
    $collection = (new Flexible)
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->insert('foo')
        ->insert('bar')
        ->insert('foo')
        ->insert('bar')
        ->insert('foo')
        ->instances();

    $bar = $collection->whereKeyNot('bar');

    expect($bar)->toBeInstanceOf(LayoutsCollection::class);
    expect($bar->count())->toBe(3);

    $baz = $collection->whereKeyNot('baz');

    expect($baz)->toBeInstanceOf(LayoutsCollection::class);
    expect($baz->count())->toBe(5);
});

it('can find multiple layouts with one of the provided keys', function () {
    $collection = (new Flexible)
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->register(fn ($layout) => $layout->key('baz'))
        ->insert('foo')
        ->insert('bar')
        ->insert('foo')
        ->insert('bar')
        ->insert('foo')
        ->insert('baz')
        ->insert('baz')
        ->instances();

    $some = $collection->whereKeyIn(['bar', 'baz']);

    expect($some)->toBeInstanceOf(LayoutsCollection::class);
    expect($some->count())->toBe(4);

    $none = $collection->whereKeyIn(['test', 'foobar']);

    expect($none)->toBeInstanceOf(LayoutsCollection::class);
    expect($none->isEmpty())->toBeTrue();
});

it('can find multiple layouts with none of the provided keys', function () {
    $collection = (new Flexible)
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->register(fn ($layout) => $layout->key('baz'))
        ->insert('foo')
        ->insert('bar')
        ->insert('foo')
        ->insert('bar')
        ->insert('foo')
        ->insert('baz')
        ->insert('baz')
        ->instances();

    $some = $collection->whereKeyNotIn(['bar', 'baz']);

    expect($some)->toBeInstanceOf(LayoutsCollection::class);
    expect($some->count())->toBe(3);

    $none = $collection->whereKeyNotIn(['foo', 'bar', 'baz']);

    expect($none)->toBeInstanceOf(LayoutsCollection::class);
    expect($none->isEmpty())->toBeTrue();
});
