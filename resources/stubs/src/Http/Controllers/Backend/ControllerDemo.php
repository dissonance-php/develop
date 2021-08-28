<?php

namespace DummyNamespace;

use Symbiotic\Core\View\View;


class DummyClass
{

    public function index()
    {
        /**
         *  template path #APP_ID#/resources/views/demo/backend.blade.php
         */
        return View::make('demo/backend');
    }

    public function test()
    {
        return ['timestamp' => time()];
    }

}
