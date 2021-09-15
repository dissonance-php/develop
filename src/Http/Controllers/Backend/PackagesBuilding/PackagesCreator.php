<?php

namespace Symbiotic\Develop\Http\Controllers\Backend\PackagesBuilding;


use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Core\Support\Str;
use Symbiotic\Develop\Services\Packages\Builder\PackageCreatorBuilder;

use Symbiotic\Http\ServerRequest;
use Symbiotic\Core\Events\CacheClear;
use Symbiotic\Core\View\View;

use function _DS\config;
use function _DS\event;
use function _DS\route;

class PackagesCreator
{

    public function index(ApplicationInterface $app)
    {
        return View::make(
            'backend/PackagesBuilding/PackagesCreator/index',
            ['packages_paths' => $this->getPackagesPaths()]
        );
    }

    public function test_packages(CoreInterface $core)
    {
        return View::make(
            'backend/PackagesBuilding/PackagesCreator/test_packages',
            ['packages_paths' => $this->getPackagesPaths()]
        );
    }


    public function create(ServerRequest $request, CoreInterface $app, PackageCreatorBuilder $builder)
    {
        $packages_path = $request->getInput('packages_path');
        if (!is_dir($packages_path) || !is_writable($packages_path)) {
            throw  new \Exception('Директория приложений не существует или не доступная для записи [' . $packages_path . ']!');
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

        if($vendor !== 'symbiotic') {
            $package->setBaseNamespace(ucfirst(Str::camel($vendor)).'\\'.ucfirst(Str::camel($package_name)));
        }
        $package->withPackageName($package_name);

        if (!empty($request->getInput('with_demo'))) {
            $package->withDemo();
        }

        $package->create();
        event(new CacheClear('all'));

        return \_DS\redirect(route('backend:develop::index'));
        /*
          $path = $request->getInput('path');
             $id = $request->getInput('id');
             if (!empty($request->getInput('app'))) {
                 if (!is_null($request->getInput('backend'))) {

                 }
             }*/

    }

    /**
     * @param ServerRequest $request
     * @param PackageCreatorBuilder $builder
     * @param CoreInterface $app
     * @throws \Exception
     */
    public function test_create(ServerRequest $request, PackageCreatorBuilder $builder, CoreInterface $app)
    {

        $packages_path = $request->getInput('packages_path');
        if (!is_dir($packages_path) || !is_writable($packages_path)) {
            throw  new \Exception('Директория приложений не существует или не доступная для записи[' . $packages_path . ']!');
        }

        $count_apps = $this->validateCount((int)$request->getInput('count_apps'));
        $count_bootstraps = $this->validateCount((int)$request->getInput('count_bootstraps'));
        $count_core_providers = $this->validateCount((int)$request->getInput('count_core_providers'));

        if ($count_apps > 0) {
            $chunk = 0;
            for ($i = 0; $i < $count_apps; $i++) {
                $vendor = 'symbiotic_' . ($chunk + 1) . '_test';
                $appCreator = $builder->createAppPackage($packages_path, 'test_module_' . \md5(microtime()), 'TestModule ' . $i);

                $appCreator->withVendor($vendor);
                $appCreator->withPackageConfigParam('develop_test', '1');
                $appCreator->withDemo();

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
                $appCreator = $builder->createFullPackage($packages_path, 'test_core_' . \md5(microtime()), 'CoreModule ' . $i);
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
                $appCreator = $builder->createFullPackage($packages_path, 'test_core_' . \md5(microtime()), 'CoreModule ' . $i);
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
        event(new CacheClear('all'));

        return \_DS\redirect(route('backend:develop::index'));

    }

    protected function getPackagesPaths()
    {
        $packages_paths = config('packages_paths');
        //Тестовые сначала, вычищать тестовые из основной долго)
        usort($packages_paths, function ($a, $b) {
            if (strpos($a, 'test') !== false) {
                return -1;
            }
            if (strpos($b, 'test') !== false) {
                return 1;
            }
            return 0;
        });

        return $packages_paths;

    }

    protected function validateCount(int $count)
    {
        if ($count > 1000 || $count < 0) {
            throw new \Exception('Количество от 0 до 10000!');
        }
        return $count;
    }

    /**
     * @param ServerRequest $request
     * @param PackageCreatorBuilder $builder
     * @param CoreInterface $app
     * @throws \Exception
     */
    public function test_delete(ServerRequest $request, PackageCreatorBuilder $builder, CoreInterface $app)
    {

        // TODO: ТУТ проходим по всем папкам пакетов и трем все у которых флаг в конфиге 'develop_test' => 1
        throw new \Exception('Экшен не доделан! Позже будет сделано))))', 69);
        event(new CacheClear('all'));

    }

}
