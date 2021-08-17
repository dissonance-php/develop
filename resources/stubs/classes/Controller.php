<?php

namespace DummyNamespace;

use Dissonance\Contracts\{App\AppConfigInterface, App\ApplicationInterface, CoreInterface, Routing\RouteInterface};
use Dissonance\Packages\Contracts\ResourcesRepositoryInterface;
use Dissonance\View\View;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};


class DummyClass
{

    public function index()
    {
        /**
         *  path #APP_ID#/resources/views/frontend/home.blade.php
         */
        return View::make('frontend/index');
    }


}
