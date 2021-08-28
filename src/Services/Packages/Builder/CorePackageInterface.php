<?php

namespace Symbiotic\Develop\Services\Packages\Builder;

interface  CorePackageInterface extends ComposerConfigInterface
{

    public function withBootstrap();

    public function withCoreProviders();

    public function withOutBootstrap();

    public function withOutCoreProvider();
}