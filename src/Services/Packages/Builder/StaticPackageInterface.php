<?php

namespace Dissonance\Develop\Services\Packages\Builder;

interface  StaticPackageInterface extends ComposerConfigInterface
{

    /**
     * Флаг принудительной перезаписи приложения
     *
     * Если установлен, то папка приложения будет очищена и персоздана
     */
    public function forceCreate();

    public function create();

    public function withOutVendorDirectory();
}