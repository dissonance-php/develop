<?php

namespace Dissonance\Develop\Debug\Routing;

use Dissonance\Develop\Services\Debug\Timer;

use Dissonance\Routing\Settlement;
use Dissonance\Routing\SettlementsInterface;

class Settlements implements SettlementsInterface
{

    /**
     * @var SettlementsInterface
     */
    protected $object;

    /**
     * @var Timer
     */
    protected $timer;


    public function __construct(SettlementsInterface $object, Timer $timer)
    {
        $this->object = $object;
        $this->timer = $timer;
    }

    public function getByRouter(string $router)
    {
        $name = $this->timer->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->timer->end($name);

        return $data;
    }

    public function getByUrl(string $url): ?Settlement
    {
        $name = $this->timer->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        $this->timer->end($name);

        return $data;
    }

    public function getByKey(string $key, $value, $all = false)
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