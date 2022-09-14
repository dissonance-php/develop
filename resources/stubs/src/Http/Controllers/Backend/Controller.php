<?php

namespace DummyNamespace;

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
         *  template path #APP_ID#/resources/views/backend/index.blade.php
         */
        return $this->view->make('backend/index');
    }

    public function test(): array
    {
        return ['timestamp' => time()];
    }

}
