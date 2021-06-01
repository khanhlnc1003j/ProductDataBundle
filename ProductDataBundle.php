<?php

namespace Starfruit\ProductDataBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Starfruit\ProductDataBundle\Tools\Installer;
use Pimcore\Extension\Bundle\Traits\StateHelperTrait;

class ProductDataBundle extends AbstractPimcoreBundle
{
    use StateHelperTrait;


    public function getJsPaths()
    {
        return [
            '/bundles/blog/js/pimcore/startup.js'
        ];
    }

     /**
     * @return Installer
     */
    public function getInstaller()
    {
        return $this->container->get(Installer::class);
    }
}