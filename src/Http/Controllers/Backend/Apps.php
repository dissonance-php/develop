<?php

namespace  Symbiotic\Develop\Http\Controllers\Backend;



use Symbiotic\Apps\AppsRepositoryInterface;
use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\View\ViewFactory;
use Symbiotic\Routing\RouteInterface;
use Symbiotic\Routing\RouterInterface;
use Symbiotic\Develop\Services\Monitoring\PackagesInfo;
use Symbiotic\View\View;
use Psr\Http\Message\ServerRequestInterface;

class Apps
{

    public function __construct(protected ViewFactory $view)
    {
    }


    public function index(CoreInterface $core, PackagesInfo $packages)
    {

        return $this->view->make('backend/apps/index',
            ['packages' => $packages]);

    }

    public function app(CoreInterface $core, RouteInterface $route, PackagesInfo $packages)
    {
        $app_id = $route->getParam('app_id');
        /**
         * @var  ApplicationInterface $app
         * @var  RouterInterface $routing
         */
        $app = $core[AppsRepositoryInterface::class]->get($app_id);

        $routing = $core[RouterInterface::class];

        $routes = [
           'api' => $routing->getByNamePrefix('api:'.$app_id),
           'backend' => $routing->getByNamePrefix('backend:'.$app_id),
           'frontend' => $routing->getByNamePrefix($app_id),
           'default' => $routing->getByNamePrefix('default:'.$app_id),
        ];

        return $this->view->make('backend/apps/app',
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
            'api' => $routing->getSettlementRoutes('api:'.$app_id),
            'backend' => $routing->getSettlementRoutes('backend:'.$app_id),
            'frontend' => $routing->getSettlementRoutes($app_id),
            'default' => $routing->router('default')->getNamedRoutes(),
        ];
        return $this->view->make('backend/apps/routes', [
            'routes' => $routes,
            'app'=>$app
        ]);

    }
}
