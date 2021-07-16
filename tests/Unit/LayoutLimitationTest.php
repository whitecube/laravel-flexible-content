<?php

namespace Tests\Unit;

use Whitecube\LaravelFlexibleContent\Flexible;
use Tests\Fixtures\CustomLayout;

it('can limit the whole flexible container\'s layout count', function() {
    $flexible = new Flexible();

    expect($flexible->getLimit())->toBeNull();

    $flexible->limit(1);

    expect($flexible->getLimit())->toBeOne();

    // TODO : add a single instance
    // TODO : add another one, wrapped in a try...catch and expect an exception to be thrown ?
});

it('can remove the whole flexible container\'s limit by providing a negative integer', function() {
    $flexible = (new Flexible())->limit(1);

    expect($flexible->getLimit())->toBeOne();

    // TODO : add a single instance

    $flexible->limit(-1);

    expect($flexible->getLimit())->toBeNull();

    // TODO : add another single instance
    // TODO : expect the layout instances count to be 2.
});

it('can define a layout-specific limit from custom layout class', function() {
    $layout = new CustomLayout();

    $flexible = (new Flexible())->register($layout);

    expect($layout->getLimit())->toBeOne();

    // TODO : add a custom layout
    // TODO : add another custom layout and expect an exception to be thrown ?
});

it('can override a layout-specific limit from custom layout class during registration', function() {
    $layout = new CustomLayout();

    $flexible = (new Flexible())->register($layout, -1);

    expect($layout->getLimit())->toBeNull();

    // TODO : add a custom layout
    // TODO : expect the layout instances count to be 2.
});

it('can set a layout-specific limit from closure registration', function() {
    $layout = null;

    $flexible = (new Flexible())->register(function($default) use (&$layout) {
        $layout = $default->key('foo')->limit(1);
    });

    expect($layout->getLimit())->toBeOne();

    // TODO : add a foo layout
    // TODO : add another foo layout and expect an exception to be thrown ?
});

it('can override a layout-specific limit from closure during registration', function() {
    $layout = null;

    $flexible = (new Flexible())->register(function($default) use (&$layout) {
        $layout = $default->key('foo')->limit(1);
    }, -1);
    
    expect($layout->getLimit())->toBeNull();

    // TODO : add a foo layout
    // TODO : expect the layout instances count to be 2.
});
