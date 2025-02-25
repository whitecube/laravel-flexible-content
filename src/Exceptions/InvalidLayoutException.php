<?php

namespace Whitecube\LaravelFlexibleContent\Exceptions;

use InvalidArgumentException;

class InvalidLayoutException extends InvalidArgumentException
{
    /**
     * Create a new exception instance with given arguments
     *
     * @param  mixed  $argument
     */
    public static function make($argument): InvalidArgumentException
    {
        $type = gettype($argument);

        if (is_object($argument)) {
            $type .= ' of type "'.get_class($argument).'"';
        } elseif (is_string($argument)) {
            $type .= ' "'.(strlen($argument) > 160 ? substr($argument, 0, 160).'...' : $argument).'"';
        }

        return new static('Cannot use '.$type.' as Flexible layout.');
    }
}
