<?php

namespace Symbiotic\Develop\Services\Routing;


use Symbiotic\Routing\RouteInterface;
use Symbiotic\Routing\RouterInterface;
use Symbiotic\Routing\SettlementsRouter;

class RouterHelper
{
    protected ?RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $settlement
     *
     * @return array|RouteInterface[]
     */
    public function getBySettlement(string $settlement): array
    {
        if($this->router instanceof SettlementsRouter) {
            return $this->fromSettlementRouter($settlement);
        } else {
            return $this->fromBaseRouter($settlement);
        }
    }

    protected function fromBaseRouter(string $settlement): array
    {

    }

    protected function fromSettlementRouter(string $settlement): array
    {

    }
}