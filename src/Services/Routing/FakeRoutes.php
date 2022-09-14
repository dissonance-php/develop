<?php

namespace Symbiotic\Develop\Services\Routing;

use Symbiotic\Routing\AppRouting;
use Symbiotic\Routing\RouterInterface;

/**
 * @covers
 */
class FakeRoutes extends AppRouting
{
    public function backendRoutes(RouterInterface $router):void
    {
        $this->loadTestRoutes($router);
    }

    public function apiRoutes(RouterInterface $router):void
    {
        $this->loadTestRoutes($router);
    }

    public function defaultRoutes(RouterInterface $router):void
    {
        $this->loadTestRoutes($router);

    }

    public function frontendRoutes(RouterInterface $router):void
    {
        $this->loadTestRoutes($router);

    }

    protected function loadTestRoutes($router)
    {
        /**
         * @var RouterInterface $router
         */
        //$router = $this->router;
        // base routes /test(n+1)
        $this->generateTestRoutes($router,'test');


        //  group base  /test_group(n+1)
        $router->group([], function(RouterInterface $router) {
            $this->generateTestRoutes($router,'test_group');
        });

        //  group with params
        $router->group([
            'as' => 'group_prefix',
            'prefix' => 'group_prefix',
            'namespace' => 'Prefix',
            'app' =>  $this->app_id,
            'middleware' => ['middleware1']
        ], function(RouterInterface $router) {
            $this->generateTestRoutes($router,'test_groupcc');
            $router->group([
                'as' => 'subgroup',
                'prefix' => 'subgroup',
                'namespace' => 'Subgroup\\',
                'app' => $this->app_id,
                'middleware' => ['middleware1', 'middleware2']
            ], function(RouterInterface $router) {
                $this->generateTestRoutes($router,'test_subgroup');
            });
            $router->group([
                'as' => 'subgroup_base_namespace',
                'prefix' => 'subgroup_base_namespace',
                'namespace' => '\\Subgroup\\',
                'app' => $this->app_id,
            ], function(RouterInterface $router) {
                $this->generateTestRoutes($router,'test_subgroup');
            });
        });

    }
    protected function generateTestRoutes(RouterInterface $router, $name, $module = null)
    {
        for($i = 1; $i < 10; $i++) {
            $route_uri = $name.$i;
            $router->get($route_uri, $this->prepareTestRouteParams([
                'uses' => $route_uri,
                'as' => $route_uri,
            ]));
        }
    }

    protected function prepareTestRouteParams($params) {
        foreach ([
                     'path',
                     'as',
                     'uses',
                     'app',
                 ] as $v) {
            if(!array_key_exists($v, $params)) {
                $params[$v] = null;
            } elseif($v == 'uses') {
                $params[$v] = 'Controller@'. $params[$v];
            } elseif($v == 'as') {
                $params[$v] = 'name_'. $params[$v];
            }
        }

        return $params;
    }

    protected function fillRouteTestParams($params)
    {
        foreach ([
                     'path',
                     'as',
                     'uses',
                     'app',
                 ] as $v) {
            if(!array_key_exists($v, $params)) {
                $params[$v] = null;
            }
        }
        return $params;
    }
}
