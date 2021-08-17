<?php

namespace Dissonance\Develop\Controllers\Backend;


use Dissonance\Contracts\App\ApplicationInterface;
use Dissonance\Contracts\CoreInterface;
use Dissonance\Develop\Services\PackageCreatorService;
use Dissonance\Develop\Services\Packages\PackageCreatorBuilder;
use Dissonance\Develop\Services\Packages\StaticPackageCreator;
use Dissonance\Http\Request;
use Dissonance\Http\ServerRequest;
use Dissonance\Events\CacheClear;
use Dissonance\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\CacheInterface;
use function _DS\event;
use const _DS\DS;

class PackageCreator
{

    public function index(ApplicationInterface $app)
    {
        return View::make('backend/package_creator/index');
    }

    /**
     * @param ServerRequest $request
     * @param PackageCreatorBuilder $builder
     * @param CoreInterface $app
     * @throws \Exception
     */
    public function benchmark(ServerRequest $request, PackageCreatorBuilder $builder, CoreInterface $app)
    {

        $modules_path = $app['config::base_path'] . DS . 'modules_test';
        for ($i = 0; $i < 50; $i++) {
            $vendor = 'dissonance_' . ($i + 1) . '_test';
            for ($p = 0; $p < 20; $p++) {
                $appCreator = $builder->createAppPackage($modules_path, 'test_module_' . \md5(microtime()), 'TestModule ' . $i);
                $appCreator->withVendor($vendor);
                $appCreator->create();
            }
            // Создаем пакет для нагрузки ядра
           /* $appCreator = $builder->createFullPackage($modules_path, 'test_module_' . \md5(microtime()), 'TestModule ' . $i);
            $appCreator->withVendor($vendor);
            $appCreator->withOutCoreProvider();
            $appCreator->create();*/
        }

    }

    public function create(ServerRequest $request, CoreInterface $app, PackageCreatorBuilder $builder)
    {
        $modules_path = $app['config::base_path'] . '/modules_test';
        $package = $builder->createAppPackage($modules_path, 'test_module_' . time(), 'TestModule ' . time());
        $package->create();
       event(new CacheClear());


        /*
          $path = $request->getInput('path');
             $id = $request->getInput('id');
             if (!empty($request->getInput('app'))) {
                 if (!is_null($request->getInput('backend'))) {

                 }
             }*/


    }
}
