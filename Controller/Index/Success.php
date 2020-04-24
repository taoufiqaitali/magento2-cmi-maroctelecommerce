<?php

namespace cmi\cmiecom\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Success extends \cmi\cmiecom\Controller\Index
{

    public function execute()
    {
    $params_request = $this->getRequest()->getParams();
	$order_id = $params_request["oid"];	
	 $order = $this->getOrderFactory()->create()->loadByIncrementId($order_id);
	$this->getCheckoutSession()->setLastSuccessQuoteId($order->getQouteId());
	$this->getCheckoutSession()->setLastQuoteId($order->getQouteId());
	$this->getCheckoutSession()->setLastOrderId($order->getEntityId());
	$result_redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
	$result_redirect->setUrl($this->getStoreManager()->getStore()->getBaseUrl() . 'checkout/onepage/success');
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$cartObject = $objectManager->create('Magento\Checkout\Model\Cart')->truncate();
	$cartObject->saveQuote();
	return $result_redirect;
    }
}



/*$this->checkoutSession->getLastSuccessQuoteId()
$this->checkoutSession->getLastQuoteId()
this->checkoutSession->getLastOrderId()



$this->checkoutSession->setLastSuccessQuoteId(order->getQouteId())
$this->checkoutSession->setLastQuoteId(order->getQouteId())
this->checkoutSession->setLastOrderId(order->getEntityId())*/