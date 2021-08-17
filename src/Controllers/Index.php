<?php

namespace Dissonance\App\Demo\Controllers;

use Dissonance\Contracts\App\AppConfigInterface;
use Dissonance\Contracts\App\ApplicationInterface;
use Dissonance\Contracts\Routing\RouteInterface;
use Dissonance\Mimetypes\MimeTypesMini;
use Dissonance\Http\DownloadResponse;
use Dissonance\Packages\AssetsRepositoryInterface;
use Dissonance\Packages\Contracts\ResourcesRepositoryInterface;
use Dissonance\View\View;
use Psr\Http\Message\ResponseInterface;
use function _DS\response;

class Index
{
    /**
     * @route 'app_id::index'
     * @uri  /framework_root/app_id/ - корневой екшен приложения
     *
     * @return \Dissonance\View\View
     * @uses \DummyNamespace\Routing::frontendRoutes()
     *
     * @see  \Dissonance\Routing\AppRouting::frontendRoutes()
     */
    public function index(ApplicationInterface $app)
    {
        $actions = [
            'array' => 'Array action',
            'file' => 'File response action',
            'download' => 'File download action',
            'error404' => 'Error 404 action',
            'default::'.$app->getId().'.md5_route' => 'Framework app default route'
        ];

        $controller = [
            'class' => __CLASS__,
            'method' => __METHOD__,
            'view' => 'frontend/index',
        ];

        return View::make($controller['view'], [
            'actions' => $actions,
            'controller' => $controller,
            'route' => $app['route'],
            'app' => $app
        ]);

    }

    /**
     * @route 'app_id::view'
     * @uri  /framework_root/app_id/view/
     *
     * @return \Dissonance\View\View
     * @uses \DummyNamespace\Routing::frontendRoutes()
     *
     * @see  \Dissonance\Routing\AppRouting::frontendRoutes()
     */
    public function view(ApplicationInterface $app)
    {
        $controller = [
            'class' => __CLASS__,
            'method' => __METHOD__,
            'view' => 'demo/actions/view',
        ];

        return View::make($controller['view'], [
            'controller' => $controller,
            'route' => $app['route'],
            'app' => $app
        ]);
    }

    /**
     * @route 'app_id::array'
     * @uri  /framework_root/app_id/array
     *
     * @param ApplicationInterface $app
     * @param RouteInterface $route
     * @return array
     * @uses \DummyNamespace\Routing::frontendRoutes()
     *
     * @see  \Dissonance\Routing\AppRouting::frontendRoutes()
     */
    public function array(ApplicationInterface $app, RouteInterface $route)
    {
        return [
            'app' => [
                'id' => $app->getId(),
                'name' => $app->getAppName(),
                'title' => $app->getAppTitle(),
                'parent_app' => $app->getParentAppId()

            ],
            'controller' => [
                'class' => __CLASS__,
                'method' => __METHOD__,
            ],
            'route' =>  $route->getAction(),

        ];
    }

    /**
     * @route 'app_id::array'
     * @uri  /framework_root/app_id/file/
     *
     * @return ResponseInterface
     * @uses \DummyNamespace\Routing::frontendRoutes()
     *
     * @see  \Dissonance\Routing\AppRouting::frontendRoutes()
     */
    public function file(ResponseInterface $response, ApplicationInterface $app)
    {
        /**
         * @var AssetsRepositoryInterface|ResourcesRepositoryInterface $resources
         */
        $resources = $app['resources'];
        $asset_file_path = 'js/app.js';

        $file = $resources->getAssetFileStream($app->getId(), $asset_file_path);

        $mime = (new MimeTypesMini())->getMimeType($asset_file_path);
        $response->withHeader('content-type', $mime);

        return $response->withBody($file);
    }

    /**
     * @route 'app_id::download'
     * @uri  /framework_root/app_id/download/
     *
     * @return ResponseInterface
     * @uses \DummyNamespace\Routing::frontendRoutes()
     *
     * @see  \Dissonance\Routing\AppRouting::frontendRoutes()
     */
    public function download(ApplicationInterface $app)
    {
        /**
         * @var AssetsRepositoryInterface|ResourcesRepositoryInterface $resources
         */
        $resources = $app['resources'];
        $asset_file_path = 'js/app.js';

        $file = $resources->getAssetFileStream($app->getId(), $asset_file_path);

        if($file) {
            return new DownloadResponse($file, $asset_file_path);
        }
        return response(404);
    }

    /**
     * @route 'app_id::error404'
     * @uri  /framework_root/app_id/error404/
     *
     * @return ResponseInterface
     * @uses \DummyNamespace\Routing::frontendRoutes()
     *
     * @see  \Dissonance\Routing\AppRouting::frontendRoutes()
     */
    public function error404()
    {
        return response(404);
    }


    /**
     * @route('default::app_id.md5_route')
     * @uri  /framework_root/default_d2r4334tf3fd34rdd23dd33d3/
     *
     * @return array
     *
     * @uses \DummyNamespace\Routing::defaultRoutes()
     *
     * @see  \Dissonance\Routing\AppRouting::defaultRoutes()
     */
    public function app_md5(AppConfigInterface $config)
    {
        return ['md5' => \md5($config->getId())];
    }
}
