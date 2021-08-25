<?php

namespace  Dissonance\Develop\Http\Controllers\Backend\PackagesBuilding;


use Dissonance\Apps\ApplicationInterface;
use Dissonance\Core\CoreInterface;
use Dissonance\Develop\Services\Packages\PackageCreatorBuilder;

use Dissonance\Develop\Services\Packages\SetBuilder\Builder;
use Dissonance\Http\ServerRequest;
use Dissonance\Core\Events\CacheClear;
use Dissonance\Core\View\View;

use function _DS\config;
use function _DS\event;
use const _DS\DS;

class SetBuildCreator
{

    public function index(ApplicationInterface $app, Builder $builder)
    {
        return View::make(
            'backend/PackagesBuilding/SetBuildCreator/index',
            ['builder' => $builder, 'build_paths' => config('develop.set_builder.build_paths')]
        );
    }


    public function create(ServerRequest $request, CoreInterface $app, Builder $builder)
    {
        $buil_path = $request->getInput('build_path');
        $package_name = $request->getInput('package_name');
        $package_dirs = $request->getInput('package_dir');
        if(!is_dir($buil_path) || !is_writable($buil_path)) {
            throw new \Exception('Директори для сборки не существет или не доступна для записи ['.$buil_path.']!');
        }


        $builder->build($buil_path,$package_name,$package_dirs);
        if(!file_exists($modules_path)) {
            mkdir($modules_path,0777,true);
        }

        event(new CacheClear('all'));
    }
}
