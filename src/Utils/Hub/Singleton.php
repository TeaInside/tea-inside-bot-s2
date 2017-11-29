<?php

namespace Utils\Hub;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
trait Singleton
{
    private static $instance;

    /**
     * @param any
     */
    public function getInstance(...$parameters)
    {
        if (self::$instance === null) {
            self::$instance = new self(...$parameters);
        }
        return self::$instance;
    }

    /**
     * Prevent serialization.
     */
    final private function __sleep()
    {
    }

    /**
     * Prevent unserialization.
     */
    final private function __wakeup()
    {
    }

    /**
     * Prevent cloning instance.
     */
    final private function __clone()
    {
    }
}
