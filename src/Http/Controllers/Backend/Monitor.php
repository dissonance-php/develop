<?php
namespace  Symbiotic\Develop\Http\Controllers\Backend;



use Symbiotic\Apps\AppsRepositoryInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Routing\RouterInterface;
use Symbiotic\View\ViewFactory;
use Symbiotic\Develop\Services\Debug\Timer;
use Symbiotic\Develop\Services\Monitoring\PackagesInfo;


class Monitor
{

    public function __construct(protected ViewFactory $view)
    {
    }

    public function index(PackagesInfo $packages_monitor, Timer $timer)
    {
        return $this->view->make('develop::backend/monitor', [
            'timer' => $timer,
            'packages_monitor' => $packages_monitor,
        ]);
    }

    public function timer(Timer $timer)
    {
        return [
            'timers'  => $timer,
            'included_files' => count(get_included_files()),
            'memory' => [
                'fact' => \Symbiotic\Develop\Services\Debug\Timer::readableSize(memory_get_usage(),null),
                'real' => Timer::readableSize(memory_get_usage(true),null),
                'peak' =>  Timer::readableSize(memory_get_peak_usage(),null),
            ]

        ];
    }

    public function memoryWithAllBooted(AppsRepositoryInterface $appsRepository,CoreInterface $core)
    {
        $appsRepository->flush();
        gc_collect_cycles();
        $result = [
            'empty' => [
                'included_files' => count(get_included_files()),
                'memory' => [
                    'fact' => Timer::readableSize(memory_get_usage(),null),
                    'real' => Timer::readableSize(memory_get_usage(true),null),
                    'peak' => Timer::readableSize(memory_get_peak_usage(),null),
                ]
            ]
        ];

        /**
         * @var RouterInterface $router
         */
        $router = $core->get(RouterInterface::class);
        $router->getRoutes('GET');
        foreach ($appsRepository->getIds() as $c) {
            $app = $appsRepository->getBootedApp($c);
            foreach ($app->getBindings() as $k=> $v) {
                if($v['shared'] === true) {
                    $app->get($k);
                }
            }
        }

        $result['loaded'] = [
            'included_files' => count(get_included_files()),
            'memory' => [
                'fact' => Timer::readableSize(memory_get_usage(),null),
                'real' => Timer::readableSize(memory_get_usage(true),null),
                'peak' =>  Timer::readableSize(memory_get_peak_usage(),null),
            ]

        ];
        $appsRepository->flush();
        return $result;
    }

    public function phpinfo()
    {
        ob_start();
        phpinfo();
        return $this->view->make('backend/phpinfo', [ 'phpinfo' => ob_get_clean()]);
    }
}
