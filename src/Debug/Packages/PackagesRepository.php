<?php

namespace Symbiotic\Develop\Debug\Packages;

use Symbiotic\Core\CoreInterface;
use Symbiotic\Develop\Services\Debug\Timer;
use Symbiotic\Packages\PackageConfig;
use Symbiotic\Packages\PackagesLoaderInterface;
use Symbiotic\Packages\PackagesRepositoryInterface;
use function _S\core;

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

    public function load(): void
    {
        core(Timer::class)->start('load_packages');
        $this->call(__FUNCTION__, func_get_args());
        core(Timer::class)->end('load_packages');
    }

    public function has($id): bool
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function get(string $id): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getPackageConfig(string $id):?PackageConfig
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getIds(): array
    {
        $name =  core(Timer::class)->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        core(Timer::class)->end($name);
        return $data;
    }

    public function getBootstraps(): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getEventsHandlers(): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }


    public function all(): array
    {
      $name =  core(Timer::class)->start();
        $data = $this->call(__FUNCTION__, func_get_args());
        core(Timer::class)->end($name);
        return $data;
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