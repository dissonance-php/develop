<?php
namespace Dissonance\Develop\Controllers\Backend;


use Dissonance\Contracts\App\ApplicationInterface;
use Dissonance\Events\CacheClear;
use Dissonance\View\View;
use function _DS\event;

class Index
{

    public function index(ApplicationInterface $app)
    {
        $meta_title = $app->getAppTitle();
        return View::make('backend/index',
            compact([
                'meta_title'
            ]));

    }

    public function cache_clean()
    {
        event(new CacheClear());
        return 'Ложки не существует!';
    }
}