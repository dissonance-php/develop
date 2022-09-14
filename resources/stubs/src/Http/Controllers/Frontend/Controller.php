<?php

namespace DummyNamespace;

use Symbiotic\Apps\AppConfigInterface;
use Symbiotic\View\View;
use Symbiotic\View\ViewFactory;


class DummyClass
{

    public function __construct(protected ViewFactory $view)
    {
    }

    public function index(): View
    {
        /**
         *  path #APP_ID#/resources/views/frontend/home.blade.php
         */
        return $this->view->make('frontend/home');
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

}
