<?php


namespace DummyPackageNamespace;

use Symbiotic\Apps\Application;
use Symbiotic\Apps\AppsRepositoryInterface;
use Symbiotic\Container\ContainerTrait;
use Symbiotic\Container\SubContainerTrait;
use Symbiotic\Apps\ApplicationInterface;


class DummyClass extends Application implements ApplicationInterface
{
    /**
     * Тут можно добавить функционал в контейнер вашего приложения
     *
     * Также можно создать свою реализацию контейнера, импользуя трейты {@see ContainerTrait, SubContainerTrait}
     * <Обязательна реализация интерфейса> {@uses ApplicationInterface}
     *
     * Приложениями управляет репозиторий {@see AppsRepositoryInterface}
     *
     */
}