<?php
namespace Dissonance\App\Demo\Controllers\Backend;

use Dissonance\Contracts\CoreInterface;
use Dissonance\Contracts\Routing\RouteInterface;
use Dissonance\View\View;
use function _DS\response;


class Docs
{
    protected $langs =  [
        'en' => 'Английский',
        'ru' => 'Русский',
        'cn' => 'Китайский',
        // ну и хватит
    ];

    public function index(RouteInterface $route, CoreInterface $core)
    {
        $version = $route->getParam('version');
        $lang = $route->getParam('lang');
        if(!isset($this->langs[$lang])) {
            return response(404);
        }

        return View::make('backend/docs/'.$lang.'/'.$version.'/index', ['core' => $core, $this->langs]);

    }
}
