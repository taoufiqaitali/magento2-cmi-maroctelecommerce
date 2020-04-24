<?php

namespace cmi\cmiecom\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

use Magento\Framework\App\RequestInterface;

class Returnto extends \cmi\cmiecom\Controller\Index
{

    public function execute()
    {
        // if($this->getCheckoutSession()->getLastRealOrderId()){
			// if ($lastQuoteId = $this->getCheckoutSession()->getLastQuoteId()){
				// $quote = $this->getQuoteFactory()->create()->load($lastQuoteId);
				// $quote->setIsActive(true)->save();
			// };
		// }
	$order_id = $this->getCheckoutSession()->getLastRealOrderId();	
	$order = $this->getOrderFactory()->create()->loadByIncrementId($order_id);
	$this->getCheckoutSession()->setLastSuccessQuoteId($order->getQouteId());
	$this->getCheckoutSession()->setLastQuoteId($order->getQouteId());
	$this->getCheckoutSession()->setLastOrderId($order->getEntityId());
	$result_redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
	$result_redirect->setUrl($this->getStoreManager()->getStore()->getBaseUrl());
	return $result_redirect;
		
		
	/*$params_request = $this->getRequest()->getParams();
	$order_id = $params_request["oid"];
	 $order = $this->getOrderFactory()->create()->loadByIncrementId($order_id);
	// echo "<pre>";
		// var_dump($order->getId());
		// echo "</pre>";
		// exit;
    $resultRedirect = $this->resultRedirectFactory->create();
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
    $cart = $objectManager->get('Magento\Checkout\Model\Cart');
    $items = $order->getItemsCollection();
    foreach ($items as $item) {
        $cart->addOrderItem($item);
    }
    $cart->save();
    return $resultRedirect->setPath('checkout/cart');*/
    }
}
