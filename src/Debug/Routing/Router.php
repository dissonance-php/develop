<?php

namespace Symbiotic\Develop\Debug\Routing;

use Psr\Container\ContainerInterface;
use Symbiotic\Container\CloningContainer;
use Symbiotic\Develop\Services\Debug\Timer;
use Symbiotic\Routing\RouteInterface;
use Symbiotic\Routing\RouterInterface;

class Router implements RouterInterface, CloningContainer
{

    public function __construct(protected RouterInterface $object, protected ContainerInterface $container)
    {
    }

    public function setRoutesDomain(string $domain): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function addRoute(string|array $httpMethods, string $uri, string|array|\Closure $action): RouteInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function get(string $uri, $action): RouteInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function post(string $uri, $action): RouteInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function head(string $uri, $action): RouteInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function put(string $uri, $action): RouteInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function delete(string $uri, $action): RouteInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function options(string $uri, $action): RouteInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function group(array $attributes, \Closure $routes): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function getByName(string $name): ?RouteInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getByNamePrefix(string $name): array
    {
        $name = $this->container[Timer::class]->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->container[Timer::class]->end($name);

        return $data;
    }

    public function getRoutes(string $httpMethod = null): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function match(string $httpMethod, string $uri): ?RouteInterface
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

    public function setParams(array $params): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function getNamedRoutes(): array
    {
        return $this->call(__FUNCTION__, func_get_args());
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