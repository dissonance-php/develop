<?php

namespace Dissonance\Develop\Controllers\Backend;



use Dissonance\Apps\AppsRepositoryInterface;
use Dissonance\Contracts\App\ApplicationInterface;
use Dissonance\Contracts\CoreInterface;
use Dissonance\Contracts\Routing\RouteInterface;
use Dissonance\Contracts\Routing\RouterInterface;
use Dissonance\Develop\Services\Monitoring\PackagesInfo;
use Dissonance\View\View;
use Psr\Http\Message\ServerRequestInterface;

class Apps
{

    public function index(CoreInterface $core, PackagesInfo $packages)
    {

        return View::make('backend/apps/index',
            ['packages' => $packages]);

    }

    public function app(CoreInterface $core, RouteInterface $route,PackagesInfo $packages)
    {
        $app_id = $route->getParam('app_id');
        /**
         * @var  ApplicationInterface $app
         */
        $app = $core[AppsRepositoryInterface::class]->get($app_id);

        $routing = $core[RouterInterface::class];

        $routes = [
           'api' => $routing->getBySettlement('api:'.$app_id),
           'backend' => $routing->getBySettlement('backend:'.$app_id),
           'frontend' => $routing->getBySettlement($app_id),
           'default' => $routing->getBySettlement('default:'.$app_id),
        ];

        return View::make('backend/apps/app',
            [
                'packages' => $packages,
                'routes' => $routes,
                'app'=>$app
            ]
            );

    }

    public function routes(RouteInterface $route, CoreInterface $core)
    {
        $app_id = $route->getParam('app_id');
        $routing = $core[RouterInterface::class];
        $app = $core[AppsRepositoryInterface::class]->get($app_id);

        $routes = [
            'api' => $routing->getBySettlement('api:'.$app_id),
            'backend' => $routing->getBySettlement('backend:'.$app_id),
            'frontend' => $routing->getBySettlement($app_id),
            'default' => $routing->getBySettlement('default:'.$app_id),
        ];
        return View::make('backend/apps/routes', [
            'routes' => $routes,
            'app'=>$app
        ]);

    }
}
