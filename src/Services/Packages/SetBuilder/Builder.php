<?php


namespace Dissonance\Develop\Services\Packages\SetBuilder;


/**
 * Class Builder
 * @package Dissonance\Develop\Services\Packages\SetBuilder
 */
class Builder
{

    protected array $packages_paths = [];

    public function __construct(array $packages_paths)
    {
        foreach ($packages_paths as $path) {
            $this->packages_paths[] = rtrim($path, '/\\');
        }

    }

    public function getPackagesConfigs(array $only_packages = null): array
    {
        $packages = [];

        foreach ($this->packages_paths as $path) {
            $packages[$path] = $this->getPathPackagesConfigs($path, $only_packages);
        }

        return $packages;
    }

    private function getPathPackagesConfigs($path, array $only_packages = null): array
    {

        $path_packages = [];

        $files = array_merge(
            glob($path . '/*/composer.json', GLOB_NOSORT),
            glob($path . '/*/*/composer.json', GLOB_NOSORT)
        );

        foreach ($files as $file) {
            if (\is_readable($file)) {
                $config = @\json_decode(file_get_contents($file), true);
                if (is_array($config)) {

                    if (!isset($config['name'])) {
                        throw  new \Exception('Пакет не имеет имени [' . $file . ']!');
                    }

                    if (!$only_packages || in_array($config['name'], $only_packages)) {
                        $config['base_path'] = dirname($file);
                        $path_packages[] = $config;
                    }
                }
            }
        }

        return $path_packages;
    }
}