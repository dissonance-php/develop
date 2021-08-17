<?php

namespace Dissonance\Develop\Debug\Packages;

use Dissonance\Contracts\CoreInterface;
use Dissonance\Develop\Services\Debug\Timer;
use Dissonance\Packages\Contracts\PackagesLoaderInterface;
use Dissonance\Packages\Contracts\PackagesRepositoryInterface;
use function _DS\app;

class PackagesRepository implements PackagesRepositoryInterface
{

    /**
     * @var PackagesRepositoryInterface
     */
    protected $object;

    /**
     * @var Timer
     */
    protected $timer;


    public function __construct(PackagesRepositoryInterface $packages)
    {
        $this->object = $packages;
    }

    public function load(CoreInterface $app): void
    {
        app(Timer::class)->start('load_packages');
        $this->call(__FUNCTION__, func_get_args());
        app(Timer::class)->end('load_packages');
    }

    public function has($id): bool
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function get($id): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getPackages(): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function addPackagesLoader(PackagesLoaderInterface $loader): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function addPackage(array $config): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    protected function call($method, $parameters)
    {
        return call_user_func_array([$this->object, $method], $parameters);
    }

}