<?php

namespace Tests\Unit;

use Whitecube\LaravelFlexibleContent\Flexible;
use Whitecube\LaravelFlexibleContent\Exceptions\InstanceNotInsertableException;
use Tests\Fixtures\CustomLayout;

it('can limit the whole flexible container\'s layout count', function() {
    $flexible = (new Flexible())->register(fn ($layout) => $layout->key('foo'));

    expect($flexible->getLimit())->toBeNull();

    $flexible->limit(1);

    expect($flexible->getLimit())->toBe(1);

    $flexible->insert('foo');

    $exception = null;
    try {
        $flexible->insert('foo');
    } catch (\Exception $e) {
        $exception = $e;
    }

    expect($flexible->count())->toBe(1);
    expect($exception)->toBeInstanceOf(InstanceNotInsertableException::class);
    expect($exception->getCode())->toBe(InstanceNotInsertableException::REASON_LIMIT);
});

it('can remove the whole flexible container\'s limit by providing a negative integer', function() {
    $flexible = (new Flexible())
        ->register(fn ($layout) => $layout->key('foo'))
        ->limit(1);

    expect($flexible->getLimit())->toBe(1);

    $flexible->insert('foo');

    $flexible->limit(-1);

    expect($flexible->getLimit())->toBeNull();

    $flexible->insert('foo');

    expect($flexible->count())->toBe(2);
});

it('can define a layout-specific limit from custom layout class', function() {
    $layout = new CustomLayout();

    $flexible = (new Flexible())
        ->register($layout)
        ->register(fn ($layout) => $layout->key('foo'));

    expect($layout->getLimit())->toBe(1);

    $flexible->insert('custom');
    $flexible->insert('foo');

    $exception = null;
    try {
        $flexible->insert('custom');
    } catch (\Exception $e) {
        $exception = $e;
    }

    expect($flexible->count('custom'))->toBe(1);
    expect($flexible->count())->toBe(2);
    expect($exception)->toBeInstanceOf(InstanceNotInsertableException::class);
    expect($exception->getCode())->toBe(InstanceNotInsertableException::REASON_LAYOUT_LIMIT);
});

it('can override a layout-specific limit from custom layout class during registration', function() {
    $layout = new CustomLayout();

    $flexible = (new Flexible())->register($layout, -1);

    expect($layout->getLimit())->toBeNull();

    $flexible->insert('custom');
    $flexible->insert('custom');

    expect($flexible->count('custom'))->toBe(2);
});

it('can set a layout-specific limit from closure registration', function() {
    $layout = null;

    $flexible = (new Flexible())
        ->register(function($default) use (&$layout) {
            $layout = $default->key('foo')->limit(1);
        })
        ->register(fn ($layout) => $layout->key('bar'));

    expect($layout->getLimit())->toBe(1);

    $flexible->insert('foo');
    $flexible->insert('bar');

    $exception = null;
    try {
        $flexible->insert('foo');
    } catch (\Exception $e) {
        $exception = $e;
    }

    expect($flexible->count('foo'))->toBe(1);
    expect($flexible->count())->toBe(2);
    expect($exception)->toBeInstanceOf(InstanceNotInsertableException::class);
    expect($exception->getCode())->toBe(InstanceNotInsertableException::REASON_LAYOUT_LIMIT);
});

it('can override a layout-specific limit from closure during registration', function() {
    $layout = null;

    $flexible = (new Flexible())->register(function($default) use (&$layout) {
        $layout = $default->key('foo')->limit(1);
    }, -1);
    
    expect($layout->getLimit())->toBeNull();

    $flexible->insert('foo');
    $flexible->insert('foo');

    expect($flexible->count())->toBe(2);
});
