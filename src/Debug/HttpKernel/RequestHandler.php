<?php


namespace Symbiotic\Develop\Debug\HttpKernel;


use Psr\Container\ContainerInterface;
use Symbiotic\Container\CloningContainer;
use Symbiotic\Develop\Services\Debug\Timer;
use Psr\Http\Message\ {ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;


class RequestHandler implements RequestHandlerInterface,CloningContainer
{
    public function __construct(protected RequestHandlerInterface $object, protected ContainerInterface $container)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $name = $this->container[Timer::class]->start(get_class($this->object).'::handle');
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
        $new = clone $this;
        $new->container = $container;
        return $new;
    }


}