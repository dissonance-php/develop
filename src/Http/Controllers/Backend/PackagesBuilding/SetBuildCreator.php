<?php

namespace  Symbiotic\Develop\Http\Controllers\Backend\PackagesBuilding;


use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\View\ViewFactory;
use Symbiotic\Develop\Services\Packages\PackageCreatorBuilder;

use Symbiotic\Develop\Services\Packages\SetBuilder\Builder;
use Symbiotic\Http\ServerRequest;
use Symbiotic\Core\Events\CacheClear;
use Symbiotic\View\View;

use function _S\config;
use function _S\event;
use const _S\DS;

class SetBuildCreator
{
    public function __construct(protected ViewFactory $view)
    {
    }


    public function index(ApplicationInterface $app, Builder $builder)
    {
        return $this->view->make(
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


        event(new CacheClear('all'));
    }
}
