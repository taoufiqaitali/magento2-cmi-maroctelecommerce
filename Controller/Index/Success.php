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
	
	$this->getCheckoutSession()->setLastOrderId($order->getId());
	$this->getCheckoutSession()->setLastRealOrderId($order->getIncrementId());
	$this->getCheckoutSession()->setLastOrderStatus($order->getStatus());	

	$this->messageManager->addSuccessMessage('Your order has been successfully created!');
            
	$result_redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
	$result_redirect->setUrl($this->getStoreManager()->getStore()->getBaseUrl() . 'checkout/onepage/success');
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$cartObject = $objectManager->create('Magento\Checkout\Model\Cart')->truncate();
	$cartObject->saveQuote();
	return $result_redirect;
    }
}


