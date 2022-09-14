<?php

namespace DummyNamespace;

use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\ServiceProvider;
use DummyPackageNamespace\Services\Singleton;
use DummyPackageNamespace\Services\CloningService;
use DummyPackageNamespace\Services\LiveService;


class DummyClass extends ServiceProvider
{
    public function register(): void
    {
        // TODO: Регистрируем сервисы, вызывать сервисы тут нельзя!
        /**
         * Единый инстанс сервиса для приложения, даже при клонировании приложения
         */
        $this->app->singleton(Singleton::class, Singleton::class);

        /**
         * Сервис который будет клонировать себя при клонировании приложения
         */
        $this->app->singleton(CloningService::class, static function(ApplicationInterface $app) {
            return new CloningService($app);
        });

        /**
         * Сервис будет пересоздаваться при каждом клонировании контейнера
         * Такое поведение используется при работе с несколькими запросами
         */
        $this->app->live(LiveService::class, LiveService::class);
    }

    public function boot(): void
    {
        // TODO: Инициализируем сервисы и получаем нужные для работы"

        $this->app->get(Singleton::class);
        $this->app->get(CloningService::class);
        $this->app->get(LiveService::class);
    }
}