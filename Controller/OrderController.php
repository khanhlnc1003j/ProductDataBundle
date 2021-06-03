<?php

namespace Starfruit\ProductDataBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pimcore\Controller\KernelControllerEventInterface;
use Pimcore\Bundle\AdminBundle\Controller\AdminController;
use Pimcore\Bundle\AdminBundle\Security\User\TokenStorageUserResolver;
use Pimcore\Bundle\EcommerceFrameworkBundle\Factory;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Localizedfield;
use Pimcore\Model\DataObject\OnlineShopOrder;

/**
 * Class AdminOrderController
 *
 * @Route("/admin/starfruit/order")
 *
 * @internal
 */
class OrderController extends AdminController implements KernelControllerEventInterface
{


	/**
     * {@inheritdoc}
     */
    public function onKernelControllerEvent(ControllerEvent $event)
    {
        // set language
        $user = $this->get(TokenStorageUserResolver::class)->getUser();

        if ($user) {
            $this->get('translator')->setLocale($user->getLanguage());
            $event->getRequest()->setLocale($user->getLanguage());
        }

        // enable inherited values
        DataObject::setGetInheritedValues(true);
        Localizedfield::setGetFallbackValues(true);

        $this->orderManager = Factory::getInstance()->getOrderManager();
        $this->paymentManager = Factory::getInstance()->getPaymentManager();
    }

    /**
     * @Template
     * @Route("/order-detail/{id}", name="starfruit_order_detail")
     */
    public function detailAction(Request $request)
    {
    	$order = OnlineShopOrder::getById($request->get('id'));

        return ['order' => $order];
        // return new Response('Hello world from bloqweqweg');
    }
}
