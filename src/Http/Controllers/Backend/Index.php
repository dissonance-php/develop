<?php
namespace  Symbiotic\Develop\Http\Controllers\Backend;


use Symbiotic\Apps\ApplicationInterface;
use Symbiotic\Core\CoreInterface;
use Symbiotic\Core\Events\CacheClear;
use Symbiotic\Core\View\View;
use function _DS\event;

class Index
{

    public function index(ApplicationInterface $app)
    {
        $meta_title = $app->getAppName();
        return View::make('backend/index',
            compact([
                'meta_title'
            ]));

    }

    public function cache_clean(CoreInterface $app)
    {
        event(new CacheClear('all'));
        $path = $app('cache_path');

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        $result = [];
        /**
         * @var \SplFileInfo $file
         */
        foreach ($files as $file) {
            $result[] = $file->getRealPath();

        }

        return $result;
    }
}
