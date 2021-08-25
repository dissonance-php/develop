<?php

namespace Dissonance\Develop\Services\Packages\Builder;

/**
 * Trait ComposerConfigTrait
 * @package Dissonance\Develop\Services\Packages\Builder
 */
trait ComposerConfigTrait
{

    protected $vendor = 'dissonance';

    protected $package_name = '';

    protected $license = 'MIT';
    /**
     * @var array| [
     * [
     * "name" => "Vasya Pupkin",
     * "email" => "cybercrime@fsb.ru",
     * "homepage" => "fsb.ru"
     * ],
     * ....
     * ],
     */
    protected $authors = null;

    protected $keywords = [];

    protected $require = null;

    protected $suggest = null;

    protected $support = null;

    protected $homepage = '';

    protected $description = '';
    
    protected $composer = [];


    public function withPackageName(string $package_name): self
    {
        if (1 !== \preg_match("@^[a-z][._0-9a-z-]+$@", $package_name)) {
            throw new \Exception('Название пакета не валидно! Разрешено только [a-z-_.] и первый символ буква!');
        }
        $this->package_name = $package_name;

        return $this;
    }

    public function withAuthors(array $authors): self
    {
        $this->authors = $this->getDataObject($authors);

        return $this;
    }

    public function withVendor(string $vendor): self
    {
        if (1 !== \preg_match("@^[a-z][._0-9a-z-]+$@", $vendor)) {
            throw new \Exception('Имя вендора не валидно! Разрешено только [a-z-_.] и первый символ буква!');
        }
        $this->vendor = $vendor;

        return $this;
    }

    public function withLicense(string $license): self
    {
        $this->license = $license;

        return $this;
    }

    public function withDescription(string $desc): self
    {
        $this->description = $desc;

        return $this;
    }

    public function withRequires(array $requires): self
    {
        $this->require = $this->getDataObject($requires);

        return $this;
    }

    public function withSuggest(array $data): self
    {
        $this->suggest = $this->getDataObject($data);

        return $this;
    }

    public function withKeywords(array $data): self
    {
        $this->keywords = $data;

        return $this;
    }

    public function withSupport(array $data): self
    {
        $this->support = $this->getDataObject($data);

        return $this;
    }

    public function withHomepage(string $data): self
    {
        $this->homepage = $data;

        return $this;
    }

    protected function buildComposerConfig()
    {
        if (empty($this->package_name)) {
            throw new \Exception('Нет имени пакета!');
        }
        $this->composer['name'] = $this->vendor . '/' . $this->package_name;
        $this->composer['description'] = $this->description;
        if (!empty($this->license)) {
            $this->composer['license'] = $this->license;
        }
        $this->composer['keywords'] = $this->keywords;
        if (!empty($this->homepage)) {
            $this->composer['homepage'] = $this->homepage;
        }

        if (!empty($this->authors)) {
            $this->composer['authors'] = $this->authors;
        }

        if (!empty($this->support)) {
            $this->composer['support'] = $this->support;
        }
        $this->composer['require'] = $this->require ? $this->require : new \stdClass();
        $this->composer['autoload'] = new \stdClass();// чтобы красиво выглядело
        if (!empty($this->suggest)) {
            $this->composer['suggest'] = $this->suggest;
        }

        return $this->composer;
    }

    protected function getDataObject(array $data): object
    {
        $obj = new \stdClass();
        foreach ($data as $k => $v) {
            $obj->{$k} = $v;
        }
        return $obj;
    }


}