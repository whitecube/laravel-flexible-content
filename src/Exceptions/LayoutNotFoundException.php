<?php

namespace Whitecube\LaravelFlexibleContent\Exceptions;

use InvalidArgumentException;

class LayoutNotFoundException extends InvalidArgumentException
{
    /**
     * Create a new exception instance with given arguments
     *
     * @param  string  $key
     */
    public static function make($key): InvalidArgumentException
    {
        return new static('Undefined layout for key "'.$key.'".');
    }
}
