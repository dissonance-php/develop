<?php

namespace DummyNamespace;


use Psr\Container\ContainerInterface;
use Symbiotic\Apps\AppConfigInterface;
use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\View\View;
use Symbiotic\Http\DownloadResponse;
use Symbiotic\Mimetypes\MimeTypesMini;
use Symbiotic\Packages\AssetsRepositoryInterface;
use Symbiotic\Packages\ResourcesRepositoryInterface;
use Symbiotic\Routing\RouteInterface;
use Psr\Http\Message\ {ResponseInterface, ServerRequestInterface, StreamInterface};

use Symbiotic\View\ViewFactory;

use function _S\response;


class DummyClass
{

    public function __construct(protected ViewFactory $view)
    {
    }

    /**
     * Корневой публичный экшен приложения
     *
     * @route('#APP_ID#::index')
     * @uri  /framework_root/#APP_ID#/ - корневой екшен приложения
     *
     * @param ApplicationInterface $app
     *
     * @return View
     *
     * @uses \DummyPackageNamespace\Routing::frontendRoutes()
     * @see  \Symbiotic\Routing\AppRouting::frontendRoutes()
     */
    public function index(ApplicationInterface $app)
    {
        $actions = [
            /**
             * @see \Symbiotic\Core\View\route()
             *  В шаблоне, если нет префикса роутера [app_id::], то будет установлен префикс текущего приложения [#APP_ID#::array]
             */
            'array' => 'Array action',
            'file' => 'File response action',
            'download' => 'File download action',
            'error404' => 'Error 404 action',
            'backend:' . $app->getId() . '::index' => 'Admin base action',
            'backend:' . $app->getId() . '::test' => 'Admin Test action',
            'default::' . $app->getId() . '.md5_route' => 'Framework default route'
        ];

        $controller = [
            'class' => __CLASS__,
            'method' => __METHOD__,
            'view' => 'demo/index',
        ];

        return $this->view->make($controller['view'], [
            'actions' => $actions,
            'controller' => $controller,
            'route' => $app['route'],
            'app' => $app
        ]);
    }


    /**
     * @route('#APP_ID#::array')
     * @uri  /framework_root/#APP_ID#/array/
     *
     * @param ApplicationInterface $app
     * @param RouteInterface       $route
     *
     * @return array
     *
     * @uses \DummyNamespace\Routing::frontendRoutes()
     * @see  \Symbiotic\Routing\AppRouting::frontendRoutes()
     */
    public function array(ApplicationInterface $app, RouteInterface $route)
    {
        return [
            'app' => [
                'id' => $app->getId(),
                'name' => $app->getAppName(),
                'title' => $app->getAppName(),
                'parent_app' => $app->getParentAppId()

            ],
            'controller' => [
                'class' => __CLASS__,
                'method' => __METHOD__,
            ],
            'route' => $route->getAction(),

        ];
    }

    /**
     * Возвращает файл в ответ
     *
     * @route('#APP_ID#::file')
     * @uri  /framework_root/#APP_ID#/file/
     *
     * @param ResponseInterface    $response
     * @param ApplicationInterface $app
     *
     * @return ResponseInterface
     *
     * @uses \DummyNamespace\Routing::frontendRoutes()
     * @see  \Symbiotic\Routing\AppRouting::frontendRoutes()
     */
    public function file(ResponseInterface $response, ApplicationInterface $app)
    {
        // file path PACKAGE_ROOT/assets/js/app.js
        $asset_file_path = 'js/app.js';

        /**
         * @var AssetsRepositoryInterface|ResourcesRepositoryInterface $resources
         */
        $resources = $app['resources'];
        $file = $resources->getAssetFileStream($app->getId(), $asset_file_path);

        $mime = (new MimeTypesMini())->getMimeType($asset_file_path);

        $response->withHeader('Content-Type', $mime);

        return $response->withBody($file);
    }

    /**
     * @param AppConfigInterface           $config
     * @param ResourcesRepositoryInterface $repository
     * @param ResponseInterface            $response
     *
     * @return StreamInterface|null
     */
    public function resource(
        AppConfigInterface $config,
        ResourcesRepositoryInterface $repository,
        ResponseInterface $response
    ) {
        // Path PACKAGE_ROOT/resources/docs/users.txt
        $path = 'docs/users.txt';

        $file = $repository->getResourceFileStream($config->getId(), 'docs/users.txt');
        $file->write('Egorych+++' . PHP_EOL);
        $file->rewind();
        $response->withHeader('content-type', (new MimeTypesMini())->getMimeType($path));

        return $file;
    }

    /**
     * Отдает файл для загрузки пользователем
     *
     * @route('#APP_ID#::download')
     * @uri  /framework_root/#APP_ID#/download/
     *
     * @param ApplicationInterface $app
     *
     * @return ResponseInterface
     *
     * @uses \DummyNamespace\Routing::frontendRoutes()
     * @see  \Symbiotic\Routing\AppRouting::frontendRoutes()
     */
    public function download(ApplicationInterface $app)
    {
        /**
         * @var AssetsRepositoryInterface|ResourcesRepositoryInterface $resources
         */
        $resources = $app['resources'];
        $asset_file_path = 'js/app.js';

        $file = $resources->getAssetFileStream($app->getId(), $asset_file_path);

        if ($file) {
            return new DownloadResponse($file, $asset_file_path);
        }
        return response($app, 404);
    }

    /**
     *  404 Ошибка
     *
     * @route('#APP_ID#::error404')
     * @uri  /framework_root/#APP_ID#/error404/
     *
     * @return ResponseInterface
     *
     * @uses \DummyNamespace\Routing::frontendRoutes()
     * @see  \Symbiotic\Routing\AppRouting::frontendRoutes()
     */
    public function error404(ContainerInterface $app)
    {
        return response($app, 404);
    }


    /**
     * Экшен в глобальном роутинга фреймворка
     *
     * @route('default::#APP_ID#.md5_route')
     * @uri  /framework_root/default_d2r4334tf3fd34rdd23dd33d3/
     *
     * @param AppConfigInterface $config
     *
     * @return array
     *
     * @uses \DummyNamespace\Routing::defaultRoutes()
     * @see  \Symbiotic\Routing\AppRouting::defaultRoutes()
     */
    public function app_md5(AppConfigInterface $config): array
    {
        return ['md5' => \md5($config->getId())];
    }


    /**
     * Получение сервисов
     *
     * @param CoreInterface $core_container
     *
     * @return mixed
     */

    public function core(CoreInterface $core_container)
    {
        return $core_container('config::uri_prefix', '/');
    }

    public function app(ApplicationInterface $app_container): string
    {
        return $app_container->getId();
    }

    public function config(AppConfigInterface $app_config): string
    {
        return $app_config->getAppName();
    }

    public function request(ServerRequestInterface $request): array
    {
        return $request->getAttributes();
    }

    public function response(ResponseInterface $response)
    {
        return $response->withStatus(404);
    }


    /**
     * Получение текущего роута запроса
     *
     * @param RouteInterface $route
     *
     * @return array
     */
    public function route(RouteInterface $route): array
    {
        /**
         * Параметры из патерна роута
         * /{user}/blog/{blog_name}/ = ['user' => 'ex0dus', 'countries']
         */
        return $route->getParams();
    }


}
