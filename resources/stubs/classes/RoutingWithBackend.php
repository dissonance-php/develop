<?php


namespace DummyNamespace;


use Dissonance\Contracts\Routing\RouterInterface;
use Dissonance\Routing\AppRouting;


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
         * @uses \DummyNamespace\Controllers\Backend\Index::index()
         */
        $router->get('/', [
            'uses' => 'Backend\\Index@index',
            'as' => 'index'
        ]);

        /**
         * @uri /framework_root/backend/#APP_ID#/test/
         * @uses \DummyNamespace\Controllers\Backend\Index::test()
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
         * @uri /framework_root/#APP_ID#/ - корневой екшен приложения
         * @uses \DummyNamespace\Controllers\Index::index()
         */
        $router->get('/', [
            'uses' => 'Index@index',
            'as' => 'home',
        ]);

    }
}