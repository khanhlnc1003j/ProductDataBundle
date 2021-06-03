<?php

namespace Starfruit\ProductDataBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Starfruit\ProductDataBundle\Tools\Installer;
// use Pimcore\Extension\Bundle\Traits\StateHelperTrait;

class ProductDataBundle extends AbstractPimcoreBundle
{
    // use StateHelperTrait;

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getJsPaths()
    {
        return [
            '/bundles/productdata/js/pimcore/startup.js',
            '/bundles/productdata/js/pimcore/order/OrderTab.js'
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