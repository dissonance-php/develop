<?php

namespace Symbiotic\Develop\Services\Packages\Builder;

interface  AppPackageInterface extends StaticPackageInterface
{

    /**
     * @return $this
     */
    public function withOutApp();

    /**
     * @return $this
     */
    public function withOutBackend();

    /**
     * @return $this
     */
    public function withOutFrontend();

    /**
     * @return $this
     */
    public function withOutControllers();

    /**
     * @return $this
     */
    public function withDemo();
}