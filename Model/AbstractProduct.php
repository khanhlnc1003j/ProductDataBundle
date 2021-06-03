<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Starfruit\ProductDataBundle\Model;

use Pimcore\Model\DataObject\Data\Hotspotimage;

abstract class AbstractProduct extends \Pimcore\Bundle\EcommerceFrameworkBundle\Model\AbstractProduct
{
   	public function isActive(bool $inProductList = false) :bool
    {
        return $this->isPublished();
    }

    public function getPriceSystemName() :?string
    {
        return 'default';
    }
}
