<?php


namespace Symbiotic\Develop;


use Symbiotic\Routing\RouterInterface;
use Symbiotic\Routing\AppRouting;


class Routing extends AppRouting
{

    public function backendRoutes(RouterInterface $router)
    {

        $router->group([ 'namespace' => 'Backend'], function(RouterInterface $router){
            $router->get('/timer/', [
                'uses' => 'Monitor@json',
                'as' => 'monitor.json',
                'secure' => false
            ]);
            $router->get('/phpinfo/', [
                'uses' => 'Monitor@phpinfo',
                'as' => 'monitor.phpinfo',
                'secure' => false
            ]);
            $router->get('/cache/clean/', [
                'uses' => 'Index@cache_clean',
                'as' => 'cache.clean',
                'secure' => false
            ]);


            $router->group(['prefix' => '/apps', 'as' => 'apps'], function(RouterInterface $router){
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
            $router->group([
                'prefix' => '/PackagesBuilding/packages',
                'as'=> 'PackagesBuilding.PackagesCreator',
                'namespace' => 'PackagesBuilding'
            ],  function(RouterInterface $router)
                {
                // ajhvf ajplfybz gfrtnf yf ukfdyjq
                $router->get('/', [
                    'uses' => 'PackagesCreator@index',
                    'as' => 'index',
                ]);
                $router->get('/test_packages', [
                    'uses' => 'PackagesCreator@test_packages',
                    'as' => 'test_packages',
                ]);
                $router->post('/test_create', [
                    'uses' => 'PackagesCreator@test_create',
                    'as' => 'test_create',
                ]);
                $router->get('/test_delete', [
                    'uses' => 'PackagesCreator@test_delete',
                    'as' => 'test_delete',
                ]);
                $router->post('/create', [
                    'uses' => 'PackagesCreator@create',
                    'as' => 'create',
                ]);
            });

            $router->group([
                'prefix' => '/PackagesBuilding/SetBuildCreator',
                'as'=> 'PackagesBuilding.SetBuildCreator',
                'namespace' => 'PackagesBuilding'
            ],  function(RouterInterface $router) {

                $router->get('/', [
                    'uses' => 'SetBuildCreator@index',
                    'as' => 'index',
                ]);
                $router->post('/create', [
                    'uses' => 'SetBuildCreator@create',
                    'as' => 'create',
                ]);
            });



            $router->group(['prefix' => '/docs', 'as' => 'docs'], function(RouterInterface $router){
                $router->get('/', [
                    'uses' => 'Docs@index',
                    'as' => 'index',
                ]);
            });

            $router->get('/', [
                'uses' => 'Monitor@index',
                'as' => 'index',
                'secure' => false
            ]);
        });





    }
}