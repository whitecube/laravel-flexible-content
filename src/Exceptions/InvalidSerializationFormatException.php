<?php

namespace Whitecube\LaravelFlexibleContent\Exceptions;

use InvalidArgumentException;

class InvalidSerializationFormatException extends InvalidArgumentException
{
    /**
     * Create a new exception instance with given arguments
     *
     * @param  string  $format
     */
    public static function make($format): InvalidArgumentException
    {
        return new static('Could not save flexible as "'.$format.'": method "serializeAs'.ucfirst($format).'" is undefined.');
    }
}
