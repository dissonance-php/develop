<?php


namespace Dissonance\Develop\Bootstrap;


use Dissonance\Core\BootstrapInterface;
use Dissonance\Core\CoreInterface;
use Dissonance\Core\HttpKernelInterface;
use Dissonance\Develop\Debug\HttpKernel\HttpKernel;
use Dissonance\Develop\Debug\HttpKernel\RequestHandler;
use Dissonance\Develop\Debug\Routing\Router;
use Dissonance\Develop\Debug\Routing\Settlements;
use Dissonance\Develop\Services\Debug\Timer;
use Dissonance\Develop\Debug\Packages\PackagesRepository;
use Dissonance\Http\Kernel\RouteHandler;
use Dissonance\Http\Kernel\RoutingHandler;
use Dissonance\Packages\PackagesRepositoryInterface;
use Dissonance\Routing\RouterInterface;
use Dissonance\Routing\SettlementsInterface;
use Dissonance\Routing\SettlementsRouter;
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