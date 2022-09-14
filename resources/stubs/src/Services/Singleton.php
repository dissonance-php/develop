<?php

namespace DummyNamespace;

/**
 * Class DummyClass
 * @package DummyNamespace
 *
 */
class DummyClass
{
    protected static int $instances = 0;

    public function __construct()
    {
        static::$instances++;
    }

    /**
     * @return int
     */
    public function getQuantityInstances(): int
    {
        return static::$instances;
    }
}