<?php


namespace Dissonance\Develop\Bootstrap;


use Dissonance\Contracts\BootstrapInterface;
use Dissonance\Contracts\CoreInterface;
use Dissonance\Contracts\Http\HttpKernelInterface;
use Dissonance\Develop\Debug\HttpKernel\HttpKernel;
use Dissonance\Develop\Services\Debug\Timer;
use Dissonance\Develop\Debug\Packages\PackagesRepository;
use Dissonance\Packages\Contracts\PackagesRepositoryInterface;
use function _DS\config;


class DebugBootstrap  implements BootstrapInterface {

    public function bootstrap(CoreInterface $app): void
    {
        if(config('debug')) {
            $app->singleton(Timer::class);
            $app[Timer::class]->start('All');
            if(!$app->bound(PackagesRepositoryInterface::class)) {
                $app->extend(PackagesRepositoryInterface::class, function(PackagesRepositoryInterface $object) {
                    // return $object;
                    return new PackagesRepository($object);
                });
            }


            $app->extend(HttpKernelInterface::class, function(HttpKernelInterface $object)use($app) {
                return new HttpKernel($object, $app[Timer::class]);
            });
        }
    }


}