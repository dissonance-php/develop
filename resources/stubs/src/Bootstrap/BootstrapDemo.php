<?php

namespace DummyNamespace;

use Symbiotic\Core\{CoreInterface, BootstrapInterface};
use Symbiotic\Http\Kernel\{HttpKernel, HttpRunner, RoutingHandler};



class DummyClass implements BootstrapInterface
{

    /**
     * @param CoreInterface|\Symbiotic\Core | array $app = [
     *   // Сервисы доступные сразу
     *
     *       'config' => new \Symbiotic\Config(),
     *       'events' => new \Symbiotic\Event\Dispatcher(), //{@see \Symbiotic\Core\Bootstrap\EventBootstrap::bootstrap()}
     *       'listeners' => new \Symbiotic\Event\ListenerProvider(),  //{@see \Symbiotic\Core\Bootstrap\EventBootstrap::bootstrap()}
     *
     *   // Сервисы которых может еще не быть, но они доступны сразу после отработки всех бутстраперов
     *
     *       'apps' => new \Symbiotic\Appss\AppsRepository(),  //{@see \Symbiotic\Apps\Bootstrap::bootstrap()}
     *       'cache' => new \Symbiotic\SimpleCache\Cache(),             // может и не быть пакета
     *       'resources' => new \Symbiotic\Packages\Resources(),        //{@see \Symbiotic\Packages\ResourcesBootstrap::bootstrap()}
     *       'http_factory' => new \Symbiotic\Http\PsrHttpFactory(),    //{@see \Symbiotic\Http\Bootstrap::bootstrap()}
     *
     *   // Сервисы из провайдеров, доступны после бутстрапа ядра {@see HttpRunner::run(), HttpKernel::bootstrap()}
     *
     *        // HTTP сервисы, используются в {@see HttpKernel::handle(), RoutingHandler::handle()}
     *       'router'  => new \Symbiotic\Routing\Router(),    //{@see \Symbiotic\Routing\Provider::registerRouter()}
     *       'session'  => new \Symbiotic\Session\SessionStorageInterface(),    //{@see \Symbiotic\session\NativeProvider::register()}
     *       'request' => new \Symbiotic\Http\ServerRequest(),         //{@see  HttpKernel::handle()}
     *       'cookie'  => new \Symbiotic\Http\Cookie\CookiesInterface(),//{@see \Symbiotic\Http\Cookie\CookiesProvider::register()}
     *       // Доступен только при обработке в контроллерах!!!
     *       'route' => new \Symbiotic\Routing\RouteInterface(),           //{@see \Symbiotic\Http\Kernel\RouteHandler::handle()}
     * ]
     */
    public function bootstrap(CoreInterface $app): void
    {
        // тут можно добавить свои расширения ядра и сервисы
    }
}