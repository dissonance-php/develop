<?php

namespace DummyNamespace;

use Dissonance\Apps\AppConfigInterface;
use Dissonance\Core\View\View;


class DummyClass
{

    public function index()
    {
        /**
         *  path #APP_ID#/resources/views/frontend/home.blade.php
         */
        return View::make('frontend/home');
    }

    /**
     * Экшен в глобальном роутинга фреймворка
     *
     * @route('default::#APP_ID#.md5_route')
     * @uri /framework_root/default_d2r4334tf3fd34rdd23dd33d3/
     *
     * @param AppConfigInterface $config
     *
     * @return array
     *
     * @uses \DummyNamespace\Routing::defaultRoutes()
     * @see  \Dissonance\Routing\AppRouting::defaultRoutes()
     */
    public function app_md5(AppConfigInterface $config)
    {
        return ['md5' => \md5($config->getId())];
    }

}
