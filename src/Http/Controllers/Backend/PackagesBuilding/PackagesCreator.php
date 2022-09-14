<?php

namespace Symbiotic\Develop\Http\Controllers\Backend\PackagesBuilding;


use Psr\Container\ContainerInterface;
use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Core\Events\CacheClear;
use Symbiotic\Core\Support\Str;
use Symbiotic\View\View;
use Symbiotic\View\ViewFactory;
use Symbiotic\Develop\Services\Packages\Builder\PackageCreatorBuilder;
use Symbiotic\Filesystem\Adapter\Local;
use Symbiotic\Http\ServerRequest;

use function _S\config;
use function _S\event;
use function _S\redirect;
use function _S\route;

class PackagesCreator
{
    public function __construct(protected ViewFactory $view, protected ContainerInterface $app)
    {
    }


    public function index(ApplicationInterface $app)
    {
        return $this->view->make(
            'backend/PackagesBuilding/PackagesCreator/index',
            ['packages_paths' => $this->getPackagesPaths()]
        );
    }

    protected function getPackagesPaths()
    {
        $packages_paths = config($this->app->get(CoreInterface::class), 'packages_paths');
        //Тестовые сначала, вычищать тестовые из основной долго)
        usort($packages_paths, function ($a, $b) {
            if (str_contains($a, 'test')) {
                return -1;
            }
            if (str_contains($b, 'test')) {
                return 1;
            }
            return 0;
        });

        foreach ($packages_paths as $k => $v) {
            if (str_contains($v, 'vendor')) {
                unset($packages_paths[$k]);
            }
        }
        return $packages_paths;
    }

    public function test_packages(): View
    {
        return $this->view->make(
            'backend/PackagesBuilding/PackagesCreator/test_packages',
            ['packages_paths' => $this->getPackagesPaths()]
        );
    }

    public function create(ServerRequest $request, CoreInterface $app, PackageCreatorBuilder $builder)
    {
        $packages_path = $request->getInput('packages_path');
        if (!is_dir($packages_path) || !is_writable($packages_path)) {
            throw  new \Exception(
                'Директория приложений не существует или не доступная для записи [' . $packages_path . ']!'
            );
        }
        $vendor = $request->getInput('vendor');
        $package_name = $request->getInput('package_name');
        $name = $request->getInput('name');
        $package = $builder->createAppPackage(
            $packages_path,
            \strtolower($package_name),
            $name
        );
        $package->withVendor($vendor);


        if (strpos($vendor, 'symbiotic') === false) {
            $package->setBaseNamespace(ucfirst(Str::camel($vendor)) . '\\' . ucfirst(Str::camel($package_name)));
        }
        $package->withPackageName($package_name);

        if (!empty($request->getInput('with_demo'))) {
            $package->withDemo();
        }

        $package->create();
        event($this->app, new CacheClear('all'));

        return \_S\redirect($this->app, route($app, 'backend:develop::index'),302);
        /*
          $path = $request->getInput('path');
             $id = $request->getInput('id');
             if (!empty($request->getInput('app'))) {
                 if (!is_null($request->getInput('backend'))) {

                 }
             }*/
    }

    /**
     * @param ServerRequest         $request
     * @param PackageCreatorBuilder $builder
     * @param CoreInterface         $app
     *
     * @throws \Exception
     */
    public function test_create(ServerRequest $request, PackageCreatorBuilder $builder, CoreInterface $app)
    {
        $packages_path = $request->getInput('packages_path');
        if (!is_dir($packages_path) || !is_writable($packages_path)) {
            throw  new \Exception(
                'Директория приложений не существует или не доступная для записи[' . $packages_path . ']!'
            );
        }

        $count_apps = $this->validateCount((int)$request->getInput('count_apps'));
        $count_bootstraps = $this->validateCount((int)$request->getInput('count_bootstraps'));
        $count_core_providers = $this->validateCount((int)$request->getInput('count_core_providers'));

        if ($count_apps > 0) {
            $chunk = 0;
            for ($i = 0; $i < $count_apps; $i++) {
                $vendor = 'symbiotic_' . ($chunk + 1) . '_test';
                $appCreator = $builder->createAppPackage(
                    $packages_path,
                    'test_module_' . \md5(microtime()),
                    'TestModule ' . $i
                );

                $appCreator->withVendor($vendor);
                $appCreator->withPackageConfigParam('develop_test', '1');
                $appCreator->withDemo();
                $appCreator->withAppProviders();

                $appCreator->create();
                if ($chunk == 30) {
                    $chunk = 0;
                } else {
                    $chunk++;
                }
            }
        }

        if ($count_bootstraps > 0) {
            $chunk = 0;
            for ($i = 0; $i < $count_bootstraps; $i++) {
                $vendor = 'symbiotic_' . ($chunk + 1) . '_test';
                // Создаем пакет для нагрузки ядра
                $appCreator = $builder->createFullPackage(
                    $packages_path,
                    'test_core_' . \md5(microtime()),
                    'CoreModule ' . $i
                );
                $appCreator->withVendor($vendor);
                $appCreator->withOutCoreProvider();
                $appCreator->withPackageConfigParam('develop_test', '1');

                $appCreator->create();
                if ($chunk == 30) {
                    $chunk = 0;
                } else {
                    $chunk++;
                }
            }
        }

        if ($count_core_providers > 0) {
            $chunk = 0;
            for ($i = 0; $i < $count_core_providers; $i++) {
                $vendor = 'symbiotic_' . ($chunk + 1) . '_test';
                // Создаем пакет для нагрузки ядра
                $appCreator = $builder->createFullPackage(
                    $packages_path,
                    'test_core_' . \md5(microtime()),
                    'CoreModule ' . $i
                );
                $appCreator->withVendor($vendor);
                $appCreator->withOutBootstrap();
                $appCreator->withPackageConfigParam('develop_test', '1');

                $appCreator->create();
                if ($chunk == 30) {
                    $chunk = 0;
                } else {
                    $chunk++;
                }
            }
        }
        event($this->app, new CacheClear('all'));

        return \_S\redirect($this->app, route($this->app,'backend:develop::index'));
    }

    protected function validateCount(int $count)
    {
        if ($count > 1000 || $count < 0) {
            throw new \Exception('Количество от 0 до 10000!');
        }
        return $count;
    }

    /**
     * @param ServerRequest         $request
     * @param PackageCreatorBuilder $builder
     * @param CoreInterface         $app
     *
     * @throws \Exception
     */
    public function test_delete(ServerRequest $request, PackageCreatorBuilder $builder, CoreInterface $app)
    {
        $filesystem = new Local('');
        foreach ($this->getPackagesPaths() as $path) {

            foreach ($filesystem->listDir($path) as $v) {
                $full_path = rtrim($path, '\\/') . '/' . ltrim($v, "\\/");
                if (\is_dir($full_path) && strpos($v, 'symbiotic_') !== false) {
                    $filesystem->deleteDir($full_path);
                }
            }
        }
        // TODO: ТУТ проходим по всем папкам пакетов и трем все у которых флаг в конфиге 'develop_test' => 1
        // throw new \Exception('Экшен не доделан! Позже будет сделано))))', 69);
        event($app, new CacheClear('all'));
        return redirect($app, route($app,'backend:develop::index'));
    }

    public function deleteDir(string $path)
    {
        if (!is_dir($path)) {
            return false;
        }
        /** @var \SplFileInfo $file */
        foreach ($this->getRecursiveDirectoryIterator($path, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            $this->deleteFileInfoObject($file);
        }

        return rmdir($path);
    }


}
