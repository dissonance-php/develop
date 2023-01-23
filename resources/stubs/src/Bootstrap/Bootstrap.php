<?php

namespace DummyNamespace;

use Symbiotic\Core\{CoreInterface, BootstrapInterface};
use Symbiotic\Http\Kernel\{HttpKernel, HttpRunner, RoutingHandler};
use Symbiotic\Container\DIContainerInterface;


class DummyClass implements BootstrapInterface
{

    /**
     * @param CoreInterface | array $core = [
     *   // Сервисы доступные сразу
     *
     *       'config' => new \Symbiotic\Config(), {@used-by \_S\config()}
     *       'events' => new \Symbiotic\EventDispatcher(), //{@see \Symbiotic\Core\Bootstrap\EventBootstrap::bootstrap()}
     *       'listeners' => new \Symbiotic\Events\ListenerProvider(),  //{@see \Symbiotic\Core\Bootstrap\EventBootstrap::bootstrap()}
     *
     *   // Сервисы которых может еще не быть, но они доступны сразу после отработки всех бутстраперов
     *
     *       'apps' => new \Symbiotic\Apps\AppsRepository(),  //{@see \Symbiotic\Apps\Bootstrap::bootstrap()}
     *       'cache' => new \Symbiotic\Cache\FilesystemCache(),             //{@see \Psr\SimpleCache\CacheInterface}
     *       'resources' => new \Symbiotic\Packages\Resources(),        //{@see \Symbiotic\Packages\ResourcesBootstrap::bootstrap()}
     *       'http_factory' => new \Symbiotic\Http\PsrHttpFactory(),    //{@see \Symbiotic\Http\Bootstrap::bootstrap()}
     *
     *   // Сервисы из провайдеров, доступны после бутстрапа ядра {@see HttpRunner::run(), HttpKernel::bootstrap()}
     *
     *        //  HTTP сервисы, используются в {@see HttpKernel::handle(), RoutingHandler::handle()}
     *       'router'  => new \Symbiotic\Routing\Router(),    //{@see \Symbiotic\Routing\Provider::registerRouter()}
     *       'request' => new \Symbiotic\Http\ServerRequest(),         //{@see  HttpKernel::handle()}
     *       'session'  => new \Symbiotic\Session\SessionStorageInterface(), //{@see \Symbiotic\Session\SessionStorageNative}
     *       'cookie'  => new \Symbiotic\Http\Cookie\CookiesInterface(), //{@see \Symbiotic\Http\Cookie\CookiesProvider::register()}
     *       // Доступен только при обработке в контроллерах!!!
     *       'route' => new \Symbiotic\Routing\RouteInterface(),           //{@see \Symbiotic\Http\Kernel\RouteHandler::handle()}
     * ]
     */
    public function bootstrap(DIContainerInterface $core): void
    {
        // тут можно добавить свои расширения ядра и сервисы
    }
}