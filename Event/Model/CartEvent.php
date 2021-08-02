<?php

namespace Starfruit\ProductDataBundle\Event\Model;

use Pimcore\Event\Traits\ArgumentsAwareTrait;
use Pimcore\Model\DataObject\AbstractObject;
use Symfony\Contracts\EventDispatcher\Event;
use Pimcore\Event\Model\ElementEventInterface;

class CartEvent extends Event implements ElementEventInterface
{
    use ArgumentsAwareTrait;

    /**
     * @var AbstractObject
     */
    protected $object;

    /**
     * CartEvent constructor.
     *
     * @param AbstractObject $object
     * @param array $arguments
     */
    public function __construct(AbstractObject $object, array $arguments = [])
    {
        $this->object = $object;
        $this->arguments = $arguments;
    }

    /**
     * @return AbstractObject
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param AbstractObject $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return AbstractObject
     */
    public function getElement()
    {
        return $this->getObject();
    }
}
