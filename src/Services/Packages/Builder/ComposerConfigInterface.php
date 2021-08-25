<?php

namespace Dissonance\Develop\Services\Packages\Builder;

interface  ComposerConfigInterface
{
    /**
     * @param string $package_name
     * @return $this
     */
    public function withPackageName(string $package_name);

    /**
     * @param array $authors
     * @return $this
     */
    public function withAuthors(array $authors);

    /**
     * @param string $vendor
     * @return $this
     */
    public function withVendor(string $vendor);

    /**
     * @param string $license
     * @return $this
     */
    public function withLicense(string $license);

    /**
     * @param string $desc
     * @return $this
     */
    public function withDescription(string $desc);

    /**
     * @param array $requires
     * @return $this
     */
    public function withRequires(array $requires);

    /**
     * @param array $data
     * @return $this
     */
    public function withSuggest(array $data);

    /**
     * @param array $data
     * @return $this
     */
    public function withKeywords(array $data);

    /**
     * @param array $data
     * @return $this
     */
    public function withSupport(array $data);

    /**
     * @param string $data
     * @return $this
     */
    public function withHomepage(string $data);
}