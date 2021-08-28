<?php
namespace  Symbiotic\Develop\Http\Controllers\Backend;



use Symbiotic\Develop\Services\Debug\Timer;
use Symbiotic\Develop\Services\Monitoring\PackagesInfo;
use Symbiotic\Core\View\View;

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
        return [$timer,'included_files' =>count(get_included_files())];
    }

    public function phpinfo()
    {

        ob_start();
        phpinfo();
        return View::make('backend/phpinfo', [ 'phpinfo' => ob_get_clean()]);
    }
}
