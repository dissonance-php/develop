<?php

namespace  Symbiotic\Develop\Http\Controllers\Backend;



use Symbiotic\Apps\AppsRepositoryInterface;
use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Routing\RouteInterface;
use Symbiotic\Routing\RouterInterface;
use Symbiotic\Develop\Services\Monitoring\PackagesInfo;
use Symbiotic\Core\View\View;
use Psr\Http\Message\ServerRequestInterface;

class Apps
{

    public function index(CoreInterface $core, PackagesInfo $packages)
    {

        return View::make('backend/apps/index',
            ['packages' => $packages]);

    }

    public function app(CoreInterface $core, RouteInterface $route, PackagesInfo $packages)
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
