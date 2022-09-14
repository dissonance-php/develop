<?php

declare(strict_types=1);

namespace Symbiotic\Develop\Debug\Routing;

use Symbiotic\Develop\Services\Debug\Timer;

use Symbiotic\Routing\Settlement;
use Symbiotic\Routing\SettlementInterface;
use Symbiotic\Routing\SettlementsInterface;


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

    public function getByRouter(string $router): ?SettlementInterface
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

    public function getByKey(string $key, mixed $value, $all = false): SettlementInterface|array|null
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