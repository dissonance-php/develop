<?php


namespace Symbiotic\Develop\Bootstrap;


use Psr\Http\Server\RequestHandlerInterface;
use Symbiotic\Container\DIContainerInterface;
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
use function _S\config;


class DebugBootstrap implements BootstrapInterface
{

    public function bootstrap(DIContainerInterface $core): void
    {

        if ($core('config::debug')) {
            $core->instance(Timer::class, new Timer());
            $core[Timer::class]->start('All');
            if (!$core->bound(PackagesRepositoryInterface::class)) {
                $core->extend(PackagesRepositoryInterface::class, function (PackagesRepositoryInterface $object) {
                    return new PackagesRepository($object);
                });
            }

            $core->extend(HttpKernelInterface::class, function (HttpKernelInterface $object) use ($core) {
                return new HttpKernel($object, $core[Timer::class]);
            });
            $core->extend(SettlementsRouter::class, function (RouterInterface $object) use ($core) {
                return new Router($object, $core[Timer::class]);
            });
            $core->extend(SettlementsInterface::class, function (SettlementsInterface $object) use ($core) {
                return new Settlements($object, $core[Timer::class]);
            });

            $core->extend(RoutingHandler::class, function (RequestHandlerInterface $object) use ($core) {
                return new RequestHandler($object, $core[Timer::class]);
            });
            $core->extend(RouteHandler::class, function (RequestHandlerInterface $object) use ($core) {
                return new RequestHandler($object, $core[Timer::class]);
            });
        }
    }


}