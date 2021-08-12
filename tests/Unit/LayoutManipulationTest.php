<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\Fixtures\CustomLayout;
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

it('can cast layout attributes', function() {
    $layout = (new CustomLayout())->make(null, [
        'test' => json_encode(['foo' => 'bar']),
        'birthday' => '1993-03-16'
    ]);

    expect($layout->test)->toBeArray();
    expect($layout->birthday)->toBeInstanceOf(Carbon::class);
});

it('can convert layout attributes to array', function() {
    $layout = (new Layout())->key('foo')->make(null, ['test' => true, 'something' => false]);

    $converted = $layout->toArray();

    expect($converted)->toBeArray();
    expect($converted['test'])->toBeTrue();
    expect($converted['something'])->toBeFalse();
});

it('can convert layout to a saveable array', function() {
    $layout = (new Layout())->key('foo')->limit(5)->make(null, ['test' => true, 'something' => false]);

    $converted = $layout->toSerializableArray();

    expect(array_key_exists('key', $converted))->toBeTrue();
    expect(array_key_exists('id', $converted))->toBeTrue();
    expect(array_key_exists('attributes', $converted))->toBeTrue();
    expect(array_key_exists('limit', $converted))->toBeFalse();
});

it('can convert layout to a displayable (menu) array', function() {
    $layout = (new Layout())->key('foo')->limit(5)->make(null, ['test' => true, 'something' => false]);

    $converted = $layout->toButtonArray();

    expect(array_key_exists('key', $converted))->toBeTrue();
    expect(array_key_exists('id', $converted))->toBeFalse();
    expect(array_key_exists('attributes', $converted))->toBeFalse();
    expect(array_key_exists('limit', $converted))->toBeTrue();
});

it('can convert layout to a JSON response object', function() {
    $layout = (new Layout())->key('foo')->make(null, ['test' => true, 'something' => false]);

    $converted = json_decode(json_encode($layout), true);

    expect($converted)->toBeArray();
    expect($converted['key'])->toBe('foo');
    expect(array_key_exists('id', $converted))->toBeTrue();
    expect(array_key_exists('limit', $converted))->toBeTrue();
    expect(array_key_exists('attributes', $converted))->toBeTrue();
});
