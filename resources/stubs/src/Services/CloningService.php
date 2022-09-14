<?php

namespace DummyNamespace;

use Psr\Container\ContainerInterface;
use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Container\CloningContainer;

/**
 * Class DummyClass
 * @package DummyNamespace
 *
 */
class DummyClass implements CloningContainer
{
    protected static int $instances = 0;
    protected static int $clones = 0;

    public function __construct(protected ApplicationInterface $app)
    {
        static::$instances++;
    }


    public function getQuantityInstances():int
    {
        return static::$instances;
    }

    public function getQuantityClones():int
    {
        return static::$clones;
    }

    /**
     * Updating the service in the app
     *
     * The {@see ApplicationInterface} comes as a container, we update it in a new service object.
     *
     * @param ContainerInterface|null $container
     *
     * @return $this|null
     */
    public function cloneInstance(?ContainerInterface $container): ?static
    {
        static::$clones++;
        /**
         * @var ApplicationInterface $container
         */
        $new = clone $this;
        $new->app = $container;

        return $new;
    }
}