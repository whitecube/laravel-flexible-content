<?php

namespace Tests\Unit;

use Whitecube\LaravelFlexibleContent\Layout;

it('can generate random uuid as layout ID and keep layout key', function() {
    $layout = (new Layout())->key('foo')->make(null, ['test' => true]);

    expect($layout->getKey())->toBe('foo');
    expect($layout->getId())->not->toBeNull();
});

it('can access layout attributes', function() {
    $layout = (new Layout())->key('foo')->make(null, ['test' => true]);

    expect($layout->getAttribute('test'))->toBeTrue();
    expect($layout['test'])->toBeTrue();
    expect($layout->test)->toBeTrue();
});

it('cannot access undefined layout attributes', function() {
    $layout = (new Layout())->key('foo')->make(null, ['test' => true]);

    expect($layout->getAttribute('something'))->toBeNull();
    expect($layout['something'])->toBeNull();
    expect($layout->something)->toBeNull();
});

it('can test layout attribute existence', function() {
    $layout = (new Layout())->key('foo')->make(null, ['test' => true]);

    expect(isset($layout->test))->toBeTrue();
    expect(isset($layout->something))->toBeFalse();
    expect(isset($layout['test']))->toBeTrue();
    expect(isset($layout['something']))->toBeFalse();
});

it('can unset layout attributes', function() {
    $layout = (new Layout())->key('foo')->make(null, ['test' => true, 'something' => true]);

    expect($layout->test)->toBeTrue();
    expect($layout['something'])->toBeTrue();

    unset($layout->test);
    unset($layout['something']);

    expect($layout->test)->toBeNull();
    expect($layout['something'])->toBeNull();
});

it('can convert layout attributes to array', function() {
    $layout = (new Layout())->key('foo')->make(null, ['test' => true, 'something' => false]);

    $converted = $layout->toArray();

    expect($converted)->toBeArray();
    expect($converted['test'])->toBeTrue();
    expect($converted['something'])->toBeFalse();
});
