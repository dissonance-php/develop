<?php

namespace  Dissonance\Develop\Http\Controllers\Backend\PackagesBuilding;


use Dissonance\Apps\ApplicationInterface;
use Dissonance\Core\CoreInterface;
use Dissonance\Develop\Services\Packages\PackageCreatorBuilder;

use Dissonance\Develop\Services\Packages\SetBuilder\Builder;
use Dissonance\Http\ServerRequest;
use Dissonance\Core\Events\CacheClear;
use Dissonance\Core\View\View;

use function _DS\event;
use const _DS\DS;

class SetBuildCreator
{

    public function index(ApplicationInterface $app, Builder $builder)
    {
        return View::make(
            'backend/PackagesBuilding/SetBuildCreator/index',
            ['builder' => $builder]
        );
    }


    public function create(ServerRequest $request, CoreInterface $app, Builder $builder)
    {
        $modules_path = $app['config::base_path'] . '/modules_test';
        if(!file_exists($modules_path)) {
            mkdir($modules_path,0777,true);
        }

        event(new CacheClear('all'));
    }
}
