<?php
namespace  Symbiotic\Develop\Http\Controllers\Backend;


use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\Events\CacheClear;
use Symbiotic\Core\View\View;
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
        event(new CacheClear('all'));
        return 'Ложки не существует!';
    }
}
