<?php

namespace Starfruit\ProductDataBundle\Event;

final class CartEvents
{
    /**
     * @Event("Starfruit\ProductDataBundle\Event\Model\CartEvent")
     *
     * @var string
     */
    const PRE_ADD = 'starfruit.cart.preAdd';

}
