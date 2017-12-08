<?php

namespace Bot\Telegram\Events;

use ArrayAccess;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class User implements ArrayAccess
{
    /**
     *
     * @var array
     */
    private $container = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this['lang'] = "id";
    }

    /**
     * @param string $offset
     * @param any    $value
     */
    public function offsetSet($offset, $value)
    {
        $this->container[$offset] = $value;
    }

    /**
     * @param string $offset
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * @param string $offset
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : false;
    }
}
