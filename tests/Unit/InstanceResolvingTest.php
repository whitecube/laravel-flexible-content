<?php

namespace Tests\Unit;

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
