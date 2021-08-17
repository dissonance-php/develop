<?php

namespace DummyNamespace;

use Dissonance\Contracts\{CoreInterface, BootstrapInterface};
use Dissonance\HttpKernel\{HttpKernel, HttpRunner, RoutingHandler};


class DummyClass implements BootstrapInterface
{

    /**
     * @param CoreInterface | \Dissonance\Core | array $app = [
     *   // Сервисы доступные сразу
     *
     *       'config' => new \Dissonance\Config(), {@used-by \_DS\config()}
     *       'events' => new \Dissonance\Contracts\Events\Dispatcher(), //{@see \Dissonance\Bootstrap\EventBootstrap::bootstrap()}
     *       'listeners' => new \Dissonance\Events\ListenerProvider(),  //{@see \Dissonance\Bootstrap\EventBootstrap::bootstrap()}
     *
     *   // Сервисы которых может еще не быть, но они доступны сразу после отработки всех бутстраперов
     *
     *       'apps' => new \Dissonance\Contracts\Apps\AppsRepository(),  //{@see \Dissonance\Apps\Bootstrap::bootstrap()}
     *       'cache' => new \Dissonance\SimpleCache\Cache(),             // может и не быть пакета
     *       'resources' => new \Dissonance\Packages\Resources(),        //{@see \Dissonance\Packages\ResourcesBootstrap::bootstrap()}
     *       'http_factory' => new \Dissonance\Http\PsrHttpFactory(),    //{@see \Dissonance\Http\Bootstrap::bootstrap()}
     *
     *   // Сервисы из провайдеров, доступны после бутстрапа ядра {@see HttpRunner::run(), HttpKernel::bootstrap()}
     *
     *        //  HTTP сервисы, используются в {@see HttpKernel::handle(), RoutingHandler::handle()}
     *       'router'  => new \Dissonance\Contracts\Routing\Router(),    //{@see \Dissonance\Routing\Provider::registerRouter()}
     *       'request' => new \Dissonance\Http\ServerRequest(),         //{@see  HttpKernel::handle()}
     *       'session'  => new \Dissonance\Contracts\SessionStorageInterface(), //{@see \Dissonance\Session\SessionStorageNative}
     *       'cookie'  => new \Dissonance\Http\Cookie\CookiesInterface(), //{@see \Dissonance\Http\Cookie\CookiesProvider::register()}
     *       // Доступен только при обработке в контроллерах!!!
     *       'route' => new \Dissonance\Contracts\Routing\RouteInterface(),           //{@see \Dissonance\HttpKernel\RouteHandler::handle()}
     * ]
     */
    public function bootstrap(CoreInterface $app): void
    {
        // тут можно добавить свои расширения ядра и сервисы
    }
}