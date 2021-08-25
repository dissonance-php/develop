<?php
namespace  Dissonance\Develop\Http\Controllers\Backend;



use Dissonance\Develop\Services\Debug\Timer;
use Dissonance\Develop\Services\Monitoring\PackagesInfo;
use Dissonance\Core\View\View;

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
        return print_r([$timer->getTimers(),'included_files' =>count(get_included_files())],true);
    }

    public function phpinfo()
    {

        ob_start();
        phpinfo();
        return View::make('backend/phpinfo', [ 'phpinfo' => ob_get_clean()]);
    }
}
