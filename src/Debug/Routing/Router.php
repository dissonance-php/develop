<?php

namespace Dissonance\Develop\Debug\Routing;

use Dissonance\Develop\Services\Debug\Timer;
use Dissonance\Routing\RouteInterface;
use Dissonance\Routing\RouterInterface;

class Router implements RouterInterface
{

    /**
     * @var RouterInterface
     */
    protected $object;

    /**
     * @var Timer
     */
    protected $timer;


    public function __construct(RouterInterface $object, Timer $timer)
    {
        $this->object = $object;
        $this->timer = $timer;
    }

    public function setRoutesDomain(string $domain)
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function addRoute($httpMethods, string $uri, $action): RouteInterface
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function get(string $uri, $action): RouteInterface
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function post(string $uri, $action): RouteInterface
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function head(string $uri, $action): RouteInterface
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function put(string $uri, $action): RouteInterface
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function delete(string $uri, $action): RouteInterface
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function options(string $uri, $action): RouteInterface
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function group(array $attributes, callable $routes)
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function getRoute(string $name): ?RouteInterface
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function getBySettlement(string $settlement): array
    {
        $name = $this->timer->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->timer->end($name);

        return $data;
    }

    public function getRoutes(string $httpMethod = null): array
    {
        $data = $this->call(__FUNCTION__, func_get_args());

        return $data;
    }

    public function match(string $httpMethod, string $uri): ?RouteInterface
    {
        $name = $this->timer->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->timer->end($name);

        return $data;
    }


    protected function call($method, $parameters)
    {
        return call_user_func_array([$this->object, $method], $parameters);
    }

}