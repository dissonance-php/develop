<?php
namespace Dissonance\Develop\Http\Controllers\Backend;

use Dissonance\Core\CoreInterface;
use Dissonance\Routing\RouteInterface;
use Dissonance\Core\View\View;
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
