<?php

namespace DummyNamespace;

use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\View\View;
use Symbiotic\View\ViewFactory;
use DummyPackageNamespace\Services\Singleton;
use DummyPackageNamespace\Services\CloningService;
use DummyPackageNamespace\Services\LiveService;

class DummyClass
{

    public function __construct(protected ViewFactory $view)
    {
    }

    public function index(): View
    {
        /**
         *  template path #APP_ID#/resources/views/demo/backend.blade.php
         */
        return $this->view->make('demo/backend');
    }
    public function servicesMonitor(ApplicationInterface $app):View
    {
        return $this->view->make('demo/services',[
            'singleton' => $app->get(Singleton::class),
            'live' => $app->get(LiveService::class),
            'cloning' => $app->get(CloningService::class)
        ]);
    }

    /**
     * @return array
     */
    public function test(): array
    {
        return ['timestamp' => time()];
    }
}
