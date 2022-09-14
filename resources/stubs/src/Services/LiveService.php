<?php

namespace DummyNamespace;

use Symbiotic\Apps\ApplicationInterface;


/**
 * Class DummyClass
 * @package DummyNamespace
 *
 */
class DummyClass
{
    protected static int $instances = 0;

    public function __construct(protected ApplicationInterface $app)
    {
        static::$instances++;
    }

    public function getQuantityInstances():int
    {
        return static::$instances;
    }
}