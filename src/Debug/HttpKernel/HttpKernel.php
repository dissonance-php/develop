<?php

namespace Symbiotic\Develop\Debug\HttpKernel;


use Psr\Container\ContainerInterface;
use Symbiotic\Container\CloningContainer;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Core\HttpKernelInterface;
use Symbiotic\Develop\Services\Debug\Timer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HttpKernel implements HttpKernelInterface
{

    /**
     * @var HttpKernelInterface
     */
    protected $object;

    /**
     * @var CoreInterface
     */
    protected $container;


    public function __construct(HttpKernelInterface $packages, ContainerInterface $core)
    {
        $this->object = $packages;
        $this->container = $core;
    }

    public function bootstrap(): void
    {
        $this->container[Timer::class]->start('Http Kernel Bootstrap');
        $this->call(__FUNCTION__, func_get_args());
        $this->container[Timer::class]->end('Http Kernel Bootstrap');
    }

    public function response(int $code = 200, \Throwable $exception = null): ResponseInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->container[Timer::class]->start('http_kernel_handle');
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->container[Timer::class]->end('http_kernel_handle');

        return $data;
    }

    public function terminate(ServerRequestInterface $request, ResponseInterface $response = null): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function cloneInstance(?ContainerInterface $container): ?object
    {
        $this->container = $container;
        if ($this->object instanceof CloningContainer) {
            $this->object = $this->object->cloneInstance($container);
        }
        return null;
    }


    protected function call($method, $parameters)
    {
        return call_user_func_array([$this->object, $method], $parameters);
    }

}