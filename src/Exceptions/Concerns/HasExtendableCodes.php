<?php

namespace Whitecube\LaravelFlexibleContent\Exceptions\Concerns;

trait HasExtendableCodes
{
    /**
     * Add a new exception code to the existing array
     *
     * @param int $code
     * @param string $message
     * @return void
     **/
    static public function registerCode($code, $message)
    {
        static::$codes[$code] = $message;
    }

    /**
     * Get message for given exception code
     *
     * @param int $code
     * @return null|string
     **/
    static public function getCodeMessage($code)
    {
        return static::$codes[$code] ?? null;
    }
}
