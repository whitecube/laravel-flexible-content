<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use Whitecube\LaravelFlexibleContent\Flexible;

it('can build instances from serialized data (array)', function() {
    $data = [
        ['key' => 'bar', 'id' => 'one', 'attributes' => []],
        ['key' => 'foo', 'id' => 'two', 'attributes' => []],
        ['key' => 'bar', 'id' => 'three', 'attributes' => []],
    ];

    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->build($data);

    $values = $flexible
        ->instances()
        ->map(fn ($layout) => $layout->getId());

    expect($values->implode(','))->toBe('one,two,three');
});

it('can build instances from serialized data (collection)', function() {
    $data = collect([
        (object) ['key' => 'bar', 'id' => 'one', 'attributes' => []],
        (object) ['key' => 'foo', 'id' => 'two', 'attributes' => []],
        (object) ['key' => 'bar', 'id' => 'three', 'attributes' => []],
    ]);

    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->build($data);

    $values = $flexible
        ->instances()
        ->map(fn ($layout) => $layout->getId());

    expect($values->implode(','))->toBe('one,two,three');
});

it('can build instances from serialized data (json)', function() {
    $data = json_encode([
        ['key' => 'bar', 'id' => 'one', 'attributes' => []],
        ['key' => 'foo', 'id' => 'two', 'attributes' => []],
        ['key' => 'bar', 'id' => 'three', 'attributes' => []],
    ]);

    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->build($data);

    $values = $flexible
        ->instances()
        ->map(fn ($layout) => $layout->getId());

    expect($values->implode(','))->toBe('one,two,three');
});

it('can build instances from serialized data using custom callable', function() {
    $data = [
        ['key' => 'bar', 'id' => 'one', 'attributes' => []],
        ['key' => 'foo', 'id' => 'two', 'attributes' => []],
        ['key' => 'bar', 'id' => 'three', 'attributes' => []],
    ];

    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->buildUsing(function(Flexible $container, $items) {
            foreach ($items as $item) {
                $container->insert($item['key'], $item['attributes'], null, $item['id'] . '!');
            }
        })
        ->build($data);

    $values = $flexible
        ->instances()
        ->map(fn ($layout) => $layout->getId());

    expect($values->implode(','))->toBe('one!,two!,three!');
});

it('can serialize instances into an array', function() {
    $serialized = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->insert('foo', ['test' => 0])
        ->insert('bar', ['test' => 1])
        ->insert('foo', ['test' => 2])
        ->serializeAsArray();

    expect($serialized)->toBeArray();

    foreach (['foo', 'bar', 'foo'] as $index => $key) {
        expect($serialized[$index]['key'] ?? null)->toBe($key);
        expect($serialized[$index]['id'] ?? null)->toBeString();
        expect($serialized[$index]['attributes']['test'] ?? null)->toBe($index);
    }
});

it('can serialize instances into a JSON string', function() {
    $serialized = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->insert('foo', ['test' => 0])
        ->insert('bar', ['test' => 1])
        ->insert('foo', ['test' => 2])
        ->serializeAsJson();

    expect($serialized)->toBeString();
    expect($serialized = json_decode($serialized, true))->toBeArray();

    foreach (['foo', 'bar', 'foo'] as $index => $key) {
        expect($serialized[$index]['key'] ?? null)->toBe($key);
        expect($serialized[$index]['id'] ?? null)->toBeString();
        expect($serialized[$index]['attributes']['test'] ?? null)->toBe($index);
    }
});

it('can serialize instances into a collection', function() {
    $serialized = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->insert('foo', ['test' => 0])
        ->insert('bar', ['test' => 1])
        ->insert('foo', ['test' => 2])
        ->serializeAsCollection();

    expect($serialized)->toBeInstanceOf(Collection::class);

    foreach (['foo', 'bar', 'foo'] as $index => $key) {
        expect($serialized->get($index)['key'] ?? null)->toBe($key);
        expect($serialized->get($index)['id'] ?? null)->toBeString();
        expect($serialized->get($index)['attributes']['test'] ?? null)->toBe($index);
    }
});

it('can serialize instances into a default (configurable) format', function() {
    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->insert('foo', ['test' => 0])
        ->insert('bar', ['test' => 1])
        ->insert('foo', ['test' => 2]);

    expect($flexible->serialize())->toBeString();

    $flexible->serializeUsingFormat('array');

    expect($flexible->serialize())->toBeArray();
});

it('can serialize instances using a custom callable', function() {
    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->register(fn ($layout) => $layout->key('bar'))
        ->insert('foo', ['test' => 0])
        ->insert('bar', ['test' => 1])
        ->insert('foo', ['test' => 2])
        ->serializeUsing(function(Flexible $flexible) {
            return $flexible->instances()->map(fn($instance) => $instance->getKey() . $instance->getAttributes()['test'])->implode(',');
        });

    expect($flexible->serialize())->toBe('foo0,bar1,foo2');
})->only();
