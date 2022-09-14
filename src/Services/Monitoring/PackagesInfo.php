<?php

namespace Symbiotic\Develop\Services\Monitoring;


use Symbiotic\Packages\PackagesRepositoryInterface;

class PackagesInfo
{


    protected $bootstraps = [];

    protected $providers = [];

    protected $defer_services = [];

    protected $core_packages = [];

    protected $static_packages = [];

    protected $error_static_packages = [];

    protected $apps = [];

    protected $plugins = [];

    protected $count_packages = 0;

    public function __construct(PackagesRepositoryInterface $repository)
    {

        $bootstrappers = [];
        $core_packages = [];
        $providers = [];
        $static_packages = [];
        $error_static_packages = [];
        $apps = [];
        $defered_services = [];
        $plugins_packages = [];
        foreach ($repository->all() as $config) {
            $this->count_packages++;
            $id = $config['id'] ?? \md5(\serialize($config));
            $static_package = true;
            if (isset($config['bootstrappers'])) {
                $static_package = false;
                $c = 0;
                foreach ((array)$config['bootstrappers'] as $v) {
                    $c++;
                    $bootstrappers[$v] = $id;
                }
                if (!isset($core_packages[$id])) {
                    $core_packages[$id] = [];
                }
                $core_packages[$id]['bootstrappers'] = $c;
            }
            if (isset($config['providers'])) {
                $static_package = false;
                $f = 0;
                foreach ((array)$config['providers'] as $v) {
                    $f++;
                    $providers[$v] = $id;
                }
                if (!isset($core_packages[$id])) {
                    $core_packages[$id] = [];
                }
                $core_packages[$id]['providers'] = $f;
            }

            if (isset($config['defer'])) {
                $static_package = false;
                $g = 0;
                foreach ((array)$config['defer'] as $prov => $services) {
                    $g++;
                    $defered_services[$prov] = [];
                    foreach ($services as $s) {
                        $defered_services[$prov][] = $s;
                    }
                }
                if (!isset($core_packages[$id])) {
                    $core_packages[$id] = [];
                }
                $core_packages[$id]['defer'] = $g;
            }

            if (isset($config['app'])) {
                $static_package = false;
                if (isset($core_packages[$id])) {
                    $core_packages[$id]['app'] = true;
                }
                $apps[$id] = $config;
                if (isset($config['app']['parent_app'])) {
                    $plugins_packages[$config['app']['parent_app']][] = $id;
                }
            }
            if ($static_package) {
                if (isset($config['id'])) {
                    $static_packages[] = $id;
                } else {
                    $error_static_packages[] = $id;
                }
            }
        }

        $this->bootstraps = $bootstrappers;
        $this->core_packages = $core_packages;
        $this->providers = $providers;
        $this->apps = $apps;
        $this->static_packages = $static_packages;
        $this->error_static_packages = $error_static_packages;
        $this->defer_services = $defered_services;
        $this->plugins = $plugins_packages;

    }


    public function getCountPackages(): int
    {
        return $this->count_packages;
    }

    public function getCountCorePackages(): int
    {
        return count($this->core_packages);
    }

    public function getCountBootstraps(): int
    {
        return count($this->bootstraps);
    }

    public function getCountCoreProviders(): int
    {
        return count($this->providers);
    }

    public function getCountApps(): int
    {

        return count($this->apps);
    }

    public function getCountAppsWithPlugins(): int
    {
        return count($this->plugins);
    }


    public function getCountStaticPackages(): int
    {
        return count($this->static_packages);
    }

    /**
     *
     * @return array|array[]
     */
    public function getCorePackages(): array
    {
        return $this->core_packages;
    }

    /**
     * @return array
     */
    public function getBootstraps(): array
    {
        return $this->bootstraps;
    }

    public function getApps(): array
    {
        return $this->apps;

    }

    public function getCountDeferProviders(): int
    {
        return count($this->defer_services);
    }

    public function getCountDeferServices(): int
    {
        return count($this->getDeferServices());
    }

    public function getDeferServices(): array
    {

        $services = [];
        foreach ($this->defer_services as $data) {
            foreach ($data as $v) {
                $services[] = $v;
            }
        }

        return $services;
    }

    public function getAppPlugins($id): array
    {
        return isset($this->plugins[$id]) ? $this->plugins[$id] : [];
    }

    public function getCountAppPlugins($id): int
    {
        return  \count($this->getAppPlugins($id));
    }

    /**
     * @return array|array[]
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    public function getStaticPackages(): array
    {
        return $this->static_packages;
    }

    public function getErrorPackages(): array
    {
        return $this->error_static_packages;
    }
}