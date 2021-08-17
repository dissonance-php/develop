<?php


namespace DummyPackageNamespace;

use Dissonance\App\Application;
use Dissonance\Apps\AppsRepositoryInterface;
use Dissonance\Container\ContainerTrait;
use Dissonance\Container\SubContainerTrait;
use Dissonance\Contracts\App\ApplicationInterface;


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