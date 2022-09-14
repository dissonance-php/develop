<?php


namespace Symbiotic\Develop\Services\Packages\SetBuilder;


use const _S\DS;

/**
 * За дубли кода не судите, никидываю быстро прототип
 *
 * Class Builder
 * @package Symbiotic\Develop\Services\Packages\SetBuilder
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

    /**
     *
     * @param array $package_dirs подаем конкретные папки, т.к. в разных папках могут лежать одинаковые пакеты по именам, конфликт
     */
    public function build(string $packages_path, string $package_name, array $package_dirs = [])
    {
        $root_dir = $packages_path.DS.$package_name;
        if(is_dir($root_dir)) {
            $this->deleteDir($root_dir);
        }

        mkdir($root_dir,0777,true);

        foreach ($package_dirs as $v) {
            if (is_dir($v) && is_readable($v)) {
                $composer = rtrim($v, '\\/') . DS . 'composer.json';
                if (\is_readable($composer)) {
                    $config = @\json_decode(file_get_contents($composer), true);
                    if (is_array($config)) {
                        $this->copyDir($v, $root_dir);
                    }
                }
            }
        }
    }

    protected function copyDir(string $src, string $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->copyDir($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);

    }

    protected function deleteDir(string $dir)
    {
        // Рубрика копипаста: накой использовать для удаления FileInfo?
        // Попробуйте удалить через итератор папки с картинкми на 150 G))))

        $iter = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iter,
            \RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
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