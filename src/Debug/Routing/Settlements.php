<?php

declare(strict_types=1);

namespace Symbiotic\Develop\Debug\Routing;

use Psr\Container\ContainerInterface;
use Symbiotic\Container\CloningContainer;
use Symbiotic\Develop\Services\Debug\Timer;

use Symbiotic\Routing\Settlement;
use Symbiotic\Routing\SettlementInterface;
use Symbiotic\Routing\SettlementsInterface;


class Settlements implements SettlementsInterface, CloningContainer
{

    public function __construct(protected SettlementsInterface $object, protected ContainerInterface $container)
    {
    }

    public function getByRouter(string $router): ?SettlementInterface
    {
        $name = $this->container[Timer::class]->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->container[Timer::class]->end($name);

        return $data;
    }

    public function getByUrl(string $url): ?Settlement
    {
        $name = $this->container[Timer::class]->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->container[Timer::class]->end($name);

        return $data;
    }

    public function getByKey(string $key, mixed $value, $all = false): SettlementInterface|array|null
    {
        $name = $this->container[Timer::class]->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->container[Timer::class]->end($name);

        return $data;
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