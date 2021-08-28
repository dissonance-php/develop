<?php

namespace Symbiotic\Develop\Debug\HttpKernel;


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
     * @var Timer
     */
    protected $timer;


    public function __construct(HttpKernelInterface $packages, Timer $timer)
    {
        $this->object = $packages;
        $this->timer = $timer;
    }

    public function bootstrap(): void
    {
        $this->timer->start('http_kernel_bootstrap');
        $this->call(__FUNCTION__, func_get_args());
        $this->timer->end('http_kernel_bootstrap');

    }

    public function response(int $code = 200, \Throwable $exception = null): ResponseInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->timer->start('http_kernel_handle');
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->timer->end('http_kernel_handle');
        return $data;
    }

    protected function call($method, $parameters)
    {
        return call_user_func_array([$this->object, $method], $parameters);
    }

}