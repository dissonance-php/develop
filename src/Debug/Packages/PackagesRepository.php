<?php

namespace Symbiotic\Develop\Debug\Packages;

use Psr\Container\ContainerInterface;
use Symbiotic\Container\CloningContainer;
use Symbiotic\Develop\Services\Debug\Timer;
use Symbiotic\Packages\PackageConfig;
use Symbiotic\Packages\PackagesLoaderInterface;
use Symbiotic\Packages\PackagesRepositoryInterface;


class PackagesRepository implements PackagesRepositoryInterface, CloningContainer
{


    public function __construct(
        protected PackagesRepositoryInterface $object,
        protected ContainerInterface $container
    ) {
    }

    public function load(): void
    {
        $this->container->get(Timer::class)->start('load_packages');
        $this->call(__FUNCTION__, func_get_args());
        $this->container->get(Timer::class)->end('load_packages');
    }

    public function has($id): bool
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function get(string $id): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getPackageConfig(string $id): ?PackageConfig
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getIds(): array
    {
        $name = $this->container->get(Timer::class)->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->container->get(Timer::class)->end($name);
        return $data;
    }

    public function getBootstraps(): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getEventsHandlers(): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }


    public function all(): array
    {
        $name = $this->container->get(Timer::class)->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->container->get(Timer::class)->end($name);
        return $data;
    }

    public function addPackagesLoader(PackagesLoaderInterface $loader): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function addPackage(array $config): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    protected function call($method, $parameters)
    {
        return call_user_func_array([$this->object, $method], $parameters);
    }

    public function cloneInstance(?ContainerInterface $container): ?object
    {
        $this->container = $container;
        if ($this->object instanceof CloningContainer) {
            $this->object = $this->object->cloneInstance($container);
        }
        return null;
    }

}