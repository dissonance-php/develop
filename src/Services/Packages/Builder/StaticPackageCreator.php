<?php

namespace Symbiotic\Develop\Services\Packages\Builder;

use Symbiotic\Filesystem\Filesystem;
use Symbiotic\Packages\ResourcesRepositoryInterface;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use function _DS\app;
use const _DS\DS;

/**
 * Class StaticPackageCreator
 * @package Symbiotic\Develop\Services\Packages\Builder
 */
class StaticPackageCreator implements StaticPackageInterface
{
    use ComposerConfigTrait {
        ComposerConfigTrait::buildComposerConfig as composerBuildBase;
    }

    /**
     * Корневая папка модулей
     * @var string
     */
    protected $apps_directory = '';

    /**
     * ДОполнительный преыфикс (подпака)
     * Например папка пакетов вендора
     * apps_directory/vendor_directory
     * vendor/symbiotic
     * @var string
     */
    protected $vendor_path_prefix = true;

    protected $packege_id = '';

    protected $parent_app_id = null;

    protected $title = '';

    /**
     * Принудительное пересоздание модуля
     * @used-by StaticPackageCreator::forceCreate()
     *
     * @var bool
     */
    protected $force_create = false;

    /**
     * Конфиг пакета Приложения
     * @var array
     */
    protected $symbiotic_package_config = [];

    protected $framework_uri;


    public function __construct(string $apps_directory, string $id, string $title = null)
    {
        $this->apps_directory = \rtrim($apps_directory, '\\/');
        if (1 !== \preg_match("@^[a-z][._0-9a-z-]+$@", $id)) {
            throw new \Exception('Название пакета не валидно! Разрешено только [a-z-_.] и первый символ буква!');
        }
        $this->packege_id = $id;
        $this->title = $title ? $title : \ucfirst($id);
        /**
         * @var ServerRequestInterface $request
         * @var UriInterface $uri
         */
        $uri = app(ServerRequestInterface::class)->getUri();
        $this->framework_uri = $uri->withPath(rtrim(app('base_uri'), '/\\'));
    }


    /**
     * Флаг принудительной перезаписи приложения
     *
     * Если установлен, то папка приложения будет очищена и персоздана
     */
    public function forceCreate()
    {
        $this->force_create = true;
    }

    public function create()
    {
        /**
         * Название пакета можно установить тут {@see ComposerConfigTrait::withPackageName()}
         */

        /**
         * создаем бызовый конфиг {@see StaticPackageCreator::$composer}
         */
        $this->buildComposerConfig();

        /**
         * Создаем папку пакета
         */
        $this->makeRootDir();

        /**
         * Создаем файлы пакета
         */
        $this->makePackageFiles();

        /**
         * Создаем composer.json
         */
        $this->createComposerFile();
    }

    public function withOutVendorDirectory()
    {
        $this->vendor_path_prefix = false;
    }

    protected function makePackageFiles()
    {
        $this->createAssets();
        $this->createResources();
    }

    public function getPackegeId()
    {
        return (!empty($this->parent_app_id) ? $this->parent_app_id . '.' : '') . $this->packege_id;
    }

    protected function createAssets()
    {
        $this->symbiotic_package_config['public_path'] = 'assets';
        $files = [
            'assets/css/app.css' => 'assets/css/app.css',
            'assets/js/app.js' => 'assets/js/app.js',
        ];
        $this->createFiles($files);

    }

    protected function createResources()
    {
        $this->symbiotic_package_config['resources_path'] = 'resources';
        $files = [
            'resources/views/frontend/layout.blade.php' => 'resources/views/layout.blade.php',
            'resources/views/frontend/home.blade.php' => 'resources/views/home.blade.php',
            'resources/views/frontend/errors/error.blade.php' => 'resources/views/errors/error.blade.php',
            'resources/views/frontend/errors/exception.blade.php' => 'resources/views/errors/exception.blade.php',
        ];

        $this->createFiles($files);
    }


    public function withPackageConfigParam(string $name, $value)
    {
        $this->symbiotic_package_config[$name] = $value;
    }

    protected function createComposerFile()
    {
        $this->createFile(
            $this->getPackagePath('composer.json'),
            \json_encode($this->composer, JSON_UNESCAPED_SLASHES| JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT /*| JSON_THROW_ON_ERROR*/)
        );
    }

    protected function buildComposerConfig()
    {
        if (empty($this->package_name)) {
            $this->withPackageName($this->packege_id);
        }
        if (empty($this->description)) {
            $this->withDescription('Package (' . $this->title . ') for Symbiotic.');
        }

        /**
         * @uses ComposerConfigTrait::buildComposerConfig()
         */
        $this->composerBuildBase();
        $this->symbiotic_package_config = [
            'id' => $this->getPackegeId(),
        ];
        $this->composer['extra'] = [
            'symbiotic' => &$this->symbiotic_package_config
        ];
    }


    public function withParentAppId(string $parent_app_id)
    {
        $this->parent_app_id = $parent_app_id;
    }

    protected function getPackagePath(string $path)
    {
        return $this->getPackageRootPath() . DIRECTORY_SEPARATOR . trim($path, '\\/');
    }

    protected function createFiles(array $files)
    {
        $root = $this->getPackageRootPath();
        foreach ($files as $stub_path => $file_path) {
            $this->createFile($root . DS . ltrim($file_path, '\\/'), $this->getStubFileContent($stub_path));
        }
    }

    protected function createFile($path, $content)
    {
        $this->mkdir(dirname($path));
        if (file_put_contents($path, $content) === false) {
            throw new Exception('Не возможно записать в файл приложения [' . $path . ']!');
        }
    }

    /**
     *  Получение контента балванки с заменой переменных в ктонтенте
     *
     * @param string $path Путь относительно корневой директории /resources/stubs/
     * @param array|null $replaces
     * @return string|string[]
     */
    protected function getStubFileContent(string $path, array $replaces = null)
    {
        $content = $this->getResourceFileContent('stubs' . DIRECTORY_SEPARATOR . ltrim($path, '\\/'));
        // Заменяем по маркерам
        if (!$replaces) {
            $replaces = $this->getStubReplaces();
        }

        foreach ($replaces as $key => $string) {
            $content = str_replace($key, $string, $content);
        }

        return $content;
    }

    protected function getStubReplaces()
    {
        return [
            '#FRAMEWORK_ROOT_URI#' => $this->framework_uri,
            '#APP_ID#' => $this->packege_id,
            '#APP_NAME#' => $this->title
        ];
    }

    protected function getResourceFileContent(string $path)
    {
        /**
         * @var ResourcesRepositoryInterface $resources
         */
        $resources = app('resources');
        return $resources->getResourceFileStream('develop', $path)->getContents();
    }

    protected function getPackageRootPath()
    {
        return $this->apps_directory . DIRECTORY_SEPARATOR .
            (!empty($this->vendor_path_prefix) ? \trim($this->vendor, '\\/') . DIRECTORY_SEPARATOR : '')
            . \strtolower($this->package_name);
    }

    /**
     * @param string $dir
     * @return bool
     * @todo: Надо использовать провайдер файловой системы
     * @see Filesystem::deleteDir();
     */
    protected function deleteDir(string $dir)
    {
        // todo: может сделать через glob? что быстрее? foreach(glob($dir . '/*', GLOB_NOSORT | GLOB_BRACE) as $File)
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        $result = true;
        /**
         * @var SplFileInfo $file
         */
        foreach ($files as $file) {
            $func = ($file->isDir() ? 'rmdir' : 'unlink');
            if (!$func($file->getRealPath())) {
                $result = false;
            }
        }

        return $result;
    }

    protected function mkdir($dir)
    {

        if (file_exists($dir)) {
            return;
        }
        if (!\mkdir($dir, 0777, true)) {
            throw new \Exception('Не возможно создать папку приложения [' . $dir . ']!');
        }

    }

    protected function makeRootDir()
    {
        $root_path = $this->getPackageRootPath();
        if (!$this->force_create && \file_exists($root_path)) {
            if (!$this->force_create) {
                throw new Exception('App path [' . $root_path . '] exists!');
            }
            $this->deleteDir($root_path);
        }
        if (!\file_exists($root_path)) {
            $this->mkdir($root_path);
        }
    }


}