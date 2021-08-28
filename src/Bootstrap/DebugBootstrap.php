<?php


namespace Symbiotic\Develop\Bootstrap;


use Symbiotic\Core\BootstrapInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Core\HttpKernelInterface;
use Symbiotic\Develop\Debug\HttpKernel\HttpKernel;
use Symbiotic\Develop\Debug\HttpKernel\RequestHandler;
use Symbiotic\Develop\Debug\Routing\Router;
use Symbiotic\Develop\Debug\Routing\Settlements;
use Symbiotic\Develop\Services\Debug\Timer;
use Symbiotic\Develop\Debug\Packages\PackagesRepository;
use Symbiotic\Http\Kernel\RouteHandler;
use Symbiotic\Http\Kernel\RoutingHandler;
use Symbiotic\Packages\PackagesRepositoryInterface;
use Symbiotic\Routing\RouterInterface;
use Symbiotic\Routing\SettlementsInterface;
use Symbiotic\Routing\SettlementsRouter;
use function _DS\config;


class DebugBootstrap implements BootstrapInterface
{

    public function bootstrap(CoreInterface $app): void
    {
        if (config('debug')) {
            $app->singleton(Timer::class);
            $app[Timer::class]->start('All');
            if (!$app->bound(PackagesRepositoryInterface::class)) {
                $app->extend(PackagesRepositoryInterface::class, function (PackagesRepositoryInterface $object) {
                    return new PackagesRepository($object);
                });
            }


            $app->extend(HttpKernelInterface::class, function (HttpKernelInterface $object) use ($app) {
                return new HttpKernel($object, $app[Timer::class]);
            });
            $app->extend(SettlementsRouter::class, function (RouterInterface $object) use ($app) {
                return new Router($object, $app[Timer::class]);
            });
            $app->extend(SettlementsInterface::class, function (SettlementsInterface $object) use ($app) {
                return new Settlements($object, $app[Timer::class]);
            });

            $app->extend(RoutingHandler::class, function (RoutingHandler $object) use ($app) {
                return new RequestHandler($object, $app[Timer::class]);
            });
            $app->extend(RouteHandler::class, function (RouteHandler $object) use ($app) {
                return new RequestHandler($object, $app[Timer::class]);
            });
        }
    }


}