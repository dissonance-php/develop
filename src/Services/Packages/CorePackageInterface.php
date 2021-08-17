<?php

namespace Dissonance\Develop\Services\Packages;

interface  CorePackageInterface extends ComposerConfigInterface
{

    public function withBootstrap();

    public function withCoreProviders();

    public function withOutBootstrap();

    public function withOutCoreProvider();
}