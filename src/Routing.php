<?php


namespace Dissonance\Develop;


use Dissonance\Contracts\Routing\RouterInterface;
use Dissonance\Routing\AppRouting;


class Routing extends AppRouting
{

    public function backendRoutes(RouterInterface $router)
    {

        $router->get('/timer/', [
            'uses' => 'Backend\Monitor@json',
            'as' => 'monitor.json',
            'secure' => false
        ]);
        $router->get('/phpinfo/', [
            'uses' => 'Backend\Monitor@phpinfo',
            'as' => 'monitor.phpinfo',
            'secure' => false
        ]);
        $router->get('/cache_clean/', [
            'uses' => 'Backend\Index@cache_clean',
            'as' => 'cache_clean',
            'secure' => false
        ]);
        $router->group(['prefix' => '/apps', 'as' => 'apps', 'namespace' => 'Backend'], function(RouterInterface $router){
            $router->get('{app_id}/routes', [
                'uses' => 'Apps@routes',
                'as' => 'routes',
            ]);
            $router->get('/{app_id}/', [
                'uses' => 'Apps@app',
                'as' => 'app',
            ]);

            $router->get('/', [
                'uses' => 'Apps@index',
                'as' => 'index',
            ]);
        });

        $router->group(['prefix' => '/docs', 'as' => 'docs', 'namespace' => 'Backend'], function(RouterInterface $router){
            $router->get('/', [
                'uses' => 'Docs@index',
                'as' => 'index',
            ]);
        });

        $router->group(['prefix' => '/package', 'namespace' => 'Backend'], function(RouterInterface $router){
            $router->get('/', [
                'uses' => 'PackageCreator@index',
                'as' => 'index',
            ]);$router->get('/benchmark', [
                'uses' => 'PackageCreator@benchmark',
                'as' => 'benchmark',
            ]);
            $router->get('create', [
                'uses' => 'PackageCreator@create',
                'as' => 'index',
            ]);
        });
        $router->get('/', [
            'uses' => 'Backend\Monitor@index',
            'as' => 'index',
            'secure' => false
        ]);
    }


    public function frontendRoutes(RouterInterface $router)
    {
        $router->get('/', [
            'uses' => 'Index@index',
            'as' => 'home',
        ]);

        $router->get('view', [
            'uses' => 'Index@view',
            'as' => 'view',
        ]);
        $router->get('array', [
            'uses' => 'Index@array',
            'as' => 'array',
        ]);

        $router->get('file', [
            'uses' => 'Index@file',
            'as' => 'file',
        ]);

        $router->get('download', [
            'uses' => 'Index@download',
            'as' => 'download',
        ]);

        $router->get('error404', [
            'uses' => 'Index@error404',
            'as' => 'error404',
        ]);


        $router->group([
            'prefix' => 'demo',
            'as' => 'demo'
        ], function(RouterInterface $router) {
            $router->get('/', [
                'uses' => 'Demo@index',
                'as' => 'home',
            ]);
            $router->get('view', [
                'uses' => 'Demo@view',
                'as' => 'view',
            ]);
            $router->get('array', [
                'uses' => 'Demo@array',
                'as' => 'array',
            ]);

            $router->get('file', [
                'uses' => 'Demo@file',
                'as' => 'file',
            ]);

            $router->get('download', [
                'uses' => 'Demo@download',
                'as' => 'download',
            ]);

            $router->get('error404', [
                'uses' => 'Demo@error404',
                'as' => 'error404',
            ]);

        });
    }

    /**
     * Работают в корне фремворка /framework_root/

     * для поиска роута route('default::app_id.home') {@see route()}
     *
     * @param RouterInterface $router
     */
    public function defaultRoutes(RouterInterface $router)
    {
        /**
         * @uri /framework_root/default_d2r4334tf3fd34rdd23dd33d3/ роут от корня фреймоворка
         * @route("default::app_id.md5_route")
         *
         * @uses \DummyNamespace\Controllers\Index::default()
         */
        $router->get('default_'.\md5($this->app->getId()), [
            'uses' => 'Index@app_md5',
            'as' => 'md5_route',
        ]);
    }
}