<?php

namespace Symbiotic\Develop\Services\Monitoring;

use Symbiotic\Core\CoreInterface;

class Core implements CoreInterface {

    /**
     * @var CoreInterface
     */
    protected $core;

    public function __construct(CoreInterface $core)
    {
        $this->core = $core;
    }

    public function call(callable|string $callback, array $parameters = [], string $defaultMethod = null)
    {
        // TODO: Implement call() method.
    }

}