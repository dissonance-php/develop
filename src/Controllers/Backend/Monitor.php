<?php
namespace Dissonance\Develop\Controllers\Backend;



use Dissonance\Develop\Services\Debug\Timer;
use Dissonance\Develop\Services\Monitoring\PackagesInfo;
use Dissonance\View\View;

class Monitor
{

    public function index(PackagesInfo $packages_monitor, Timer $timer)
    {
        return View::make('backend/monitor', [
            'timer' => $timer,
            'packages_monitor' => $packages_monitor,
        ]);
    }

    public function json(Timer $timer)
    {
        return $timer->getTimers();
    }

    public function phpinfo()
    {

        ob_start();
        phpinfo();
        return View::make('backend/phpinfo', [ 'phpinfo' => ob_get_clean()]);
    }
}
