<?php

namespace Symbiotic\Develop\Providers;


use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Core\ServiceProvider;
use Symbiotic\Develop\Services\Packages\SetBuilder\Builder;

class AppProvider extends ServiceProvider
{
    public function register(): void
    {
       $this->app->bind(Builder::class, function(ApplicationInterface $app){
          return new Builder(
              $app[CoreInterface::class]->get('config')->get('packages_paths')
          );
       });
    }
}