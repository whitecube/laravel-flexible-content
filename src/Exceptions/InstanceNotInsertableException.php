<?php

namespace Whitecube\LaravelFlexibleContent\Exceptions;

use InvalidArgumentException;
use Whitecube\LaravelFlexibleContent\Contracts\Layout;

class InstanceNotInsertableException extends InvalidArgumentException
{
    use Concerns\HasExtendableCodes;

    /**
     * The main refusal reason codes.
     *
     * @var int
     **/
    const REASON_LIMIT = 1;
    const REASON_LAYOUT_LIMIT = 2;

    /**
     * The main refusal reason codes.
     *
     * @var array
     **/
    static public $codes = [
        1 => 'Limit reached',
        2 => 'Layout limit reached',
    ];

    /**
     * Create a new exception instance with given arguments
     *
     * @param \Whitecube\LaravelFlexibleContent\Contracts\Layout $instance
     * @param int $code
     * @return \InvalidArgumentException
     */
    static public function make(Layout $instance, $code) : InvalidArgumentException
    {
        $reason = static::getCodeMessage($code) ?? 'Unknown refusal reason';

        return new static($reason . ': Could not insert instance "' . $instance->getId() . '" with key "' . $instance->getKey() . '".', $code);
    }
}