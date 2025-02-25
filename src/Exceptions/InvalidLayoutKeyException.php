<?php

namespace Whitecube\LaravelFlexibleContent\Exceptions;

use InvalidArgumentException;
use Whitecube\LaravelFlexibleContent\Contracts\Layout;

class InvalidLayoutKeyException extends InvalidArgumentException
{
    /**
     * Create a new exception instance with given arguments
     */
    public static function make(Layout $layout, ?string $key = null, bool $exists = false): InvalidArgumentException
    {
        $classname = get_class($layout);

        if ($key && $exists) {
            return new static('Flexible layout key "'.$key.'" for layout "'.$classname.'" is already in use.');
        }

        return new static('Undefined key for Flexible layout "'.$classname.'".');
    }
}
