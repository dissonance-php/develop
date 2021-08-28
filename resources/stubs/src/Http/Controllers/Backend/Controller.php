<?php

namespace DummyNamespace;

use Symbiotic\Core\View\View;


class DummyClass
{

    public function index()
    {
        /**
         *  template path #APP_ID#/resources/views/backend/index.blade.php
         */
        return View::make('backend/index');
    }

    public function test()
    {
        return ['timestamp' => time()];
    }

}
