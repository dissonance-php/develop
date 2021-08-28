<?php

namespace Symbiotic\Develop\Services\Packages\Builder;


class PackageCreatorBuilder
{
    const PACKAGE_TYPES = [
        'static'  => 'Пакет с шаблонами и втатикой',
        'core'  => 'Пакет для расширения ядра (Бутстрапер и провайдер)',
        'frontend_app'  => 'Пакет приложения без админки',
        'app'  => 'Пакет приложения с админкой',
        'full'  => 'Пакет приложения с админкой и расширением ядра',
    ];

    public function getTypes()
    {
        return static::PACKAGE_TYPES;
    }
    /**
     * Создает пакет с шаблонами , стилями и js
     *
     * @param string $apps_directory
     * @param string $id
     * @param string|null $title
     * @return StaticPackageCreator
     */
    public function createStaticPackage(string $apps_directory, string $id, string $title = null)
    {
        return new StaticPackageCreator($apps_directory, $id, $title);
    }

    /**
     * Создает пакет для расширения ядра с провайдером и бутстраппером
     *
     * @param string $apps_directory
     * @param string $id
     * @param string|null $title
     * @return CorePackageInterface
     */
    public function createCorePackage(string $apps_directory, string $id, string $title = null)
    {
        $package =  new SymbioticPackageCreator($apps_directory, $id, $title);
        $package->withOutApp();
        $package->withBootstrap();
        $package->withCoreProviders();

        return $package;
    }

    /**
     * @param string $apps_directory
     * @param string $id
     * @param string|null $title
     * @return AppPackageInterface|SymbioticPackageCreator
     */
    public function createAppPackage(string $apps_directory, string $id, string $title = null)
    {
        $package =  new SymbioticPackageCreator($apps_directory, $id, $title);

        return $package;
    }

    /**
     * @param string $apps_directory
     * @param string $id
     * @param string|null $title
     * @return AppPackageInterface
     */
    public function createFrontendAppPackage(string $apps_directory, string $id, string $title = null)
    {
        $package =  new SymbioticPackageCreator($apps_directory, $id, $title);
        $package->withOutBackend();

        return $package;
    }

    /**
     * Создает пакет с приложением (с админкой) и расширениями ядра (бутстрап и провайдер)
     *
     * @param string $apps_directory
     * @param string $id
     * @param string|null $title
     * @return SymbioticPackageCreator
     */
    public function createFullPackage(string $apps_directory, string $id, string $title = null)
    {
        $package =  $this->createAppPackage($apps_directory, $id, $title);
        $package->withApplicationContainer();
        $package->withAppProviders();
        $package->withBootstrap();
        $package->withCoreProviders();

        return $package;
    }




}