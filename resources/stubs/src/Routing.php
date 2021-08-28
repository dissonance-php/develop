<?php


namespace DummyPackageNamespace;


use Symbiotic\Routing\RouterInterface;
use Symbiotic\Routing\AppRouting;


class DummyClass extends AppRouting
{

    /**
     * Админские роуты приложения
     *
     * Работают в префиксе /framework_root/backend/#APP_ID#/
     * и защищены Миддлварой авторизации (еще не сделано)
     *  для поиска роута route('backend:#APP_ID#::index') {@see \_DS\route()}
     *
     *
     * @param RouterInterface $router
     */
    public function backendRoutes(RouterInterface $router)
    {
        /**
         * @uri /framework_root/backend/#APP_ID#/ - корневой екшен приложения
         * @uses \DummyPackageNamespace\Http\Controllers\Backend\Index::index()
         */
        $router->get('/', [
            'uses' => 'Backend\\Index@index',
            'as' => 'index'
        ]);
        $router->get('/home', [
            'uses' => 'Backend\\Index@index',
            'as' => 'home'
        ]);

        /**
         * @uri /framework_root/backend/#APP_ID#/test/
         * @uses \DummyPackageNamespace\Http\Controllers\Backend\Index::test()
         */
        $router->get('/test', [
            'uses' => 'Backend\\Index@test',
            'as' => 'test'
        ]);
    }

    /**
     * Публичные роуты приложения
     *
     * Работают в префиксе /framework_root/#APP_ID#/
     * для поиска роута route('#APP_ID#::home') {@see \_DS\route()}
     *
     * @param RouterInterface $router
     */
    public function frontendRoutes(RouterInterface $router)
    {
        /**
         * @link #FRAMEWORK_ROOT_URI#/#APP_ID#/
         * @uri /framework_root/#APP_ID#/ - корневой екшен приложения
         * @uses \DummyPackageNamespace\Http\Controllers\Frontend\Index::index()
         */
        $router->get('/', [
            'uses' => 'Frontend\\Index@index',
            'as' => 'home',
        ]);

    }

    /**
     * Работают в корне фремворка /framework_root/
     * для поиска роута по имени route('default::#APP_ID#.route_name') {@see \_DS\route()}
     *
     * @param RouterInterface $router
     */
    public function defaultRoutes(RouterInterface $router)
    {
        /**
         * @link #FRAMEWORK_ROOT_URI#/default_#APP_ID#/ - md5 кривой, но
         * @uri /framework_root/default_#APP_ID#/ роут от корня фреймоворка
         * @route("default:#APP_ID#::md5_route")
         *
         * @uses \DummyPackageNamespace\Http\Controllers\Frontend\Index::app_md5()
         */
        $router->get('default_' . $this->getAppId(), [
            'uses' => 'Frontend\\Index@app_md5',
            'as' => 'md5_route',
        ]);
    }
}