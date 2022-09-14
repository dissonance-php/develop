<?php
namespace  Symbiotic\Develop\Http\Controllers\Backend;


use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Core\Events\CacheClear;
use Symbiotic\View\ViewFactory;

use function _S\event;
use function _S\redirect;
use function _S\route;

class Index
{
    public function __construct(protected ViewFactory $view)
    {
    }

    public function index(ApplicationInterface $app)
    {
        $meta_title = $app->getAppName();
        return $this->view->make('backend/index',
            compact([
                'meta_title'
            ]));

    }

    public function cache_clean(CoreInterface $app)
    {
        event($app, new CacheClear('all'));

        return redirect($app, route($app,'backend:develop::index'),302);

       /* $path = $app('cache_path');
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );*/

        /*$result = [];
        /!**
         * @var \SplFileInfo $file
         *!!/
        foreach ($files as $file) {
            $result[] = $file->getRealPath();
        }

        return $result;*/
    }
}
