<?php

namespace Dissonance\Develop\Providers;


use Dissonance\Apps\ApplicationInterface;
use Dissonance\Core\CoreInterface;
use Dissonance\Core\ServiceProvider;
use Dissonance\Develop\Services\Packages\SetBuilder\Builder;

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