<?php


namespace Dissonance\Develop\Debug\HttpKernel;


use Dissonance\Develop\Services\Debug\Timer;
use Psr\Http\Message\ {ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;


class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var RequestHandlerInterface
     */
    protected $object;

    /**
     * @var Timer
     */
    protected $timer;

    public function __construct(RequestHandlerInterface $object, Timer $timer)
    {
        $this->object = $object;
        $this->timer = $timer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $name = $this->timer->start(get_class($this->object).'::handle');
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->timer->end($name);

        return $data;
    }

    protected function call($method, $parameters)
    {
        return call_user_func_array([$this->object, $method], $parameters);
    }


}