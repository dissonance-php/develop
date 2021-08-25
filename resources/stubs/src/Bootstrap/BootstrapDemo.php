<?php

namespace DummyNamespace;

use Dissonance\Core\{CoreInterface, BootstrapInterface};
use Dissonance\Http\Kernel\{HttpKernel, HttpRunner, RoutingHandler};



class DummyClass implements BootstrapInterface
{

    /**
     * @param CoreInterface|\Dissonance\Core | array $app = [
     *   // Сервисы доступные сразу
     *
     *       'config' => new \Dissonance\Config(),
     *       'events' => new \Dissonance\Event\Dispatcher(), //{@see \Dissonance\Core\Bootstrap\EventBootstrap::bootstrap()}
     *       'listeners' => new \Dissonance\Event\ListenerProvider(),  //{@see \Dissonance\Core\Bootstrap\EventBootstrap::bootstrap()}
     *
     *   // Сервисы которых может еще не быть, но они доступны сразу после отработки всех бутстраперов
     *
     *       'apps' => new \Dissonance\Appss\AppsRepository(),  //{@see \Dissonance\Apps\Bootstrap::bootstrap()}
     *       'cache' => new \Dissonance\SimpleCache\Cache(),             // может и не быть пакета
     *       'resources' => new \Dissonance\Packages\Resources(),        //{@see \Dissonance\Packages\ResourcesBootstrap::bootstrap()}
     *       'http_factory' => new \Dissonance\Http\PsrHttpFactory(),    //{@see \Dissonance\Http\Bootstrap::bootstrap()}
     *
     *   // Сервисы из провайдеров, доступны после бутстрапа ядра {@see HttpRunner::run(), HttpKernel::bootstrap()}
     *
     *        // HTTP сервисы, используются в {@see HttpKernel::handle(), RoutingHandler::handle()}
     *       'router'  => new \Dissonance\Routing\Router(),    //{@see \Dissonance\Routing\Provider::registerRouter()}
     *       'session'  => new \Dissonance\Session\SessionStorageInterface(),    //{@see \Dissonance\session\NativeProvider::register()}
     *       'request' => new \Dissonance\Http\ServerRequest(),         //{@see  HttpKernel::handle()}
     *       'cookie'  => new \Dissonance\Http\Cookie\CookiesInterface(),//{@see \Dissonance\Http\Cookie\CookiesProvider::register()}
     *       // Доступен только при обработке в контроллерах!!!
     *       'route' => new \Dissonance\Routing\RouteInterface(),           //{@see \Dissonance\Http\Kernel\RouteHandler::handle()}
     * ]
     */
    public function bootstrap(CoreInterface $app): void
    {
        // тут можно добавить свои расширения ядра и сервисы
    }
}