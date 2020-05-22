<?php

namespace cmi\cmiecom\Controller\Index;

use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManager;
use Magento\Framework\Controller\ResultFactory;

class Notify extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
{

	/**
     * @inheritDoc
     */
    public function createCsrfValidationException(
        RequestInterface $request
    ): ?InvalidRequestException {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkout_session;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customer_session;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    private $order_factory;

    /**
     * @var \Magento\Framework\App\ObjectManager
     */
    private $object_manager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $store_manager;

    /**
     * @var \cmi\cmiecom\Helper\Data2
     */
    private $helper;

    
    /**
     * @var \cmi\cmiecom\Helper\Utilities
     */
    private $utilities;

    /**
     * @var \Magento\Sales\Model\OrderRepository
     */
    private $order_repository;
    
    /**
     * @var \Magento\Sales\Model\Order\InvoiceRepository
     */
    private $invoice_repository;

    /**
     * @var \Magento\Sales\Model\Service\InvoiceService
     */
    private $invoice_service;

    /**
     * @var \Magento\Sales\Model\Order\Email\Sender\InvoiceSender
     */
    private $invoice_sender;

    /**
     * @var \Magento\Framework\DB\Transaction
     */
    private $transaction;

    /**
     * @var \Magento\Framework\App\Request\Http $request
     */
    private $request;
    
    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface $quote_repository
     */
    private $quote_repository;
    
    /**
     * @var \Magento\Quote\Model\QuoteFactory $quote_factory
     */
    private $quote_factory;
    
    /**
     * @var \Magento\Sales\Api\Data\TransactionSearchResultInterfaceFactory $trans_search
     */
    private $trans_search;
    
    public function getTransSearch()
    {
        return $this->trans_search;
    }

    public function setTransSearch(\Magento\Sales\Api\Data\TransactionSearchResultInterfaceFactory $trans_search)
    {
        $this->trans_search = $trans_search;
    }

    public function getCheckoutSession()
    {
        return $this->checkout_session;
    }

    public function getCustomerSession()
    {
        return $this->customer_session;
    }

    public function getOrderFactory()
    {
        return $this->order_factory;
    }

    public function getStoreManager()
    {
        return $this->store_manager;
    }

    public function getHelper()
    {
        return $this->helper;
    }


    public function getUtilities()
    {
        return $this->utilities;
    }

    public function getOrderRepository()
    {
        return $this->order_repository;
    }
    
    public function getInvoiceRepository()
    {
        return $this->invoice_repository;
    }
    
    public function getQuoteRepository()
    {
        return $this->quote_repository;
    }

    public function getInvoiceService()
    {
        return $this->invoice_service;
    }

    public function getInvoiceSender()
    {
        return $this->invoice_sender;
    }

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setCheckoutSession(\Magento\Checkout\Model\Session $checkout_session)
    {
        $this->checkout_session = $checkout_session;
    }

    public function setCustomerSession(\Magento\Customer\Model\Session $customer_session)
    {
        $this->customer_session = $customer_session;
    }

    public function setOrderFactory(\Magento\Sales\Model\OrderFactory $order_factory)
    {
        $this->order_factory = $order_factory;
    }

    public function setStoreManager(\Magento\Store\Model\StoreManagerInterface $store_manager)
    {
        $this->store_manager = $store_manager;
    }

    public function setHelper(\cmi\cmiecom\Helper\Data2 $helper)
    {
        $this->helper = $helper;
    }

    public function setUtilities(\cmi\cmiecom\Helper\Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    public function setOrderRepository(\Magento\Sales\Model\OrderRepository $order_repository)
    {
        $this->order_repository = $order_repository;
    }
    
    public function setInvoiceRepository(\Magento\Sales\Model\Order\InvoiceRepository $invoice_repository)
    {
        $this->invoice_repository = $invoice_repository;
    }

    public function setInvoiceService(\Magento\Sales\Model\Service\InvoiceService $invoice_service)
    {
        $this->invoice_service = $invoice_service;
    }

    public function setInvoiceSender(\Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoice_sender)
    {
        $this->invoice_sender = $invoice_sender;
    }

    public function setTransaction(\Magento\Framework\DB\Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function setRequest(\Magento\Framework\App\Request\Http $request)
    {
        $this->request = $request;
    }
    
    public function setQuoteRepository(\Magento\Quote\Api\CartRepositoryInterface $quote_repository)
    {
        $this->quote_repository = $quote_repository;
    }
    
    public function getQuoteFactory()
    {
        return $this->quote_factory;
    }

    public function setQuoteFactory(\Magento\Quote\Model\QuoteFactory $quote_factory)
    {
        $this->quote_factory = $quote_factory;
    }

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Sales\Model\OrderFactory $order_factory
     * @param \Magento\Framework\App\ObjectManagerFactory $object_factory
     * @param \Magento\Store\Model\StoreManagerInterface $store_manager
     * @param \Magento\Sales\Model\Service\InvoiceService $invoice_service
     * @param \Magento\Framework\DB\Transaction $transaction
     * @param \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoice_sender
     * @param \Magento\Sales\Model\OrderRepository $order_repository
     * @param \Magento\Sales\Model\Order\InvoiceRepository $invoice_repository
     * @param \Magento\Quote\Api\CartRepositoryInterface $quote_repository
     * @param \Magento\Quote\Model\QuoteFactory $quote_factory
     * @param \Magento\Sales\Api\Data\TransactionSearchResultInterfaceFactory $trans_search
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Model\OrderFactory $order_factory,
        \Magento\Framework\App\ObjectManagerFactory $object_factory,
        \Magento\Store\Model\StoreManagerInterface $store_manager,
        \Magento\Sales\Model\Service\InvoiceService $invoice_service,
        \Magento\Framework\DB\Transaction $transaction,
        \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoice_sender,
        \Magento\Sales\Model\OrderRepository $order_repository,
        \Magento\Sales\Model\Order\InvoiceRepository $invoice_repository,
        \Magento\Quote\Api\CartRepositoryInterface $quote_repository,
        \Magento\Quote\Model\QuoteFactory $quote_factory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Request\Http $request,
        \cmi\cmiecom\Helper\Utilities $Utilities,
        \cmi\cmiecom\Helper\Data2 $Helper,
        \Magento\Sales\Api\Data\TransactionSearchResultInterfaceFactory $trans_search
    ) {
    
        parent::__construct($context);
        $this->setOrderFactory($order_factory);
        $this->setOrderRepository($order_repository);
        $this->setInvoiceRepository($invoice_repository);
        $this->setStoreManager($store_manager);
        $this->setInvoiceService($invoice_service);
        $this->setInvoiceSender($invoice_sender);
        $this->setTransaction($transaction);
        /*$params[StoreManager::PARAM_RUN_CODE] = 'admin';
        $params[StoreManager::PARAM_RUN_TYPE] = 'store';
        $object_manager = $object_factory->create($params);*/
        $object_manager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->setHelper($Helper);
        $this->setUtilities($Utilities);
        $this->setCheckoutSession($checkoutSession);
        $this->setCustomerSession($customerSession);
        $this->setRequest($request);
        $this->setQuoteRepository($quote_repository);
        $this->setQuoteFactory($quote_factory);
        $this->setTransSearch($trans_search);
    }    

    /**
     * Separar función execute en funciones para mejorar compresión y usabilidad.
     */
    public function execute()
    {

        $params_request = $this->getRequest()->getParams();
        if (!empty($params_request)) 
        {

            $postParams = array();
            foreach ($params_request as $key => $value)
            {
                array_push($postParams, $key);
            }

            natcasesort($postParams);
            $hashval = "";
            foreach ($postParams as $param)
            {
                $paramValue = html_entity_decode(preg_replace("/\n$/","",$params_request[$param]), ENT_QUOTES, 'UTF-8'); 

                $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));

                $lowerParam = strtolower($param);
                if($lowerParam != "hash" && $lowerParam != "encoding" ) {
                    $hashval = $hashval . $escapedParamValue . "|";
                }
            }

            $storeKey = $this->getHelper()->getConfigData('Secretkey');
			$orderStatus = $this->getHelper()->getConfigData('order_status');
			 $callbackMode = $this->getHelper()->getConfigData('callback_mode');
            $confirmationMode = $this->getHelper()->getConfigData('confirmation_mode');
            $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storeKey));
            $hashval = $hashval . $escapedStoreKey;
            $calculatedHashValue = hash('sha512', $hashval);
            $actualHash = base64_encode (pack('H*',$calculatedHashValue));

            $retrievedHash = $params_request["HASH"];
            if($retrievedHash == $actualHash)
            {
                if($_POST["ProcReturnCode"] == "00")
                {

                    $order_id = $params_request["oid"];
                    $order = $this->getOrder($order_id);

                    $comment = 'CMI: Accepted payment';
                    if(!isset($orderStatus) && !is_null($orderStatus)){
						$this->changeStatusOrder($order, 'pending', 'new', NULL , $comment);
						// echo "no1";
					} 
					// var_dump($orderStatus);
					// exit;

                    $invoice = $this->getInvoiceService()->prepareInvoice($order);
                    $invoice->register();
                    $invoice->capture();
                    $invoice->save();
                    $transaction_save = $this->getTransaction()->addObject(
                            $invoice
                        )->addObject(
                        $invoice->getOrder()
                    );
                    $transaction_save->save();
                    //$this->getInvoiceSender()->send($invoice);
                    //send notification code
                    
                    /*$order->addStatusHistoryComment(
                            __('Notified customer about invoice #%1.', $invoice->getId())
                        )
                        ->setIsCustomerNotified(true)
                        ->save();*/
                    

					/*if(isset($orderStatus) && $orderStatus){
						$this->changeStatusOrder($order, $orderStatus, $orderStatus, NULL);
					} else {
						$this->changeStatusOrder($order, 'processing', 'processing', NULL);
					}*/
                    
                    $this->addTransaction($order, $this->getUtilities()->getParameters());
                    $this->deactiveCart($order);
                    
                    if($callbackMode == "0"){
				if($confirmationMode == 1) echo "ACTION=POSTAUTH"; else echo "APPROVED";
			} else if($callbackMode == "1"){
				$apigateway = $this->getHelper()->getConfigData('apigateway');
				$usernameapi = $this->getHelper()->getConfigData('usernameapi');
				$passwordapi = $this->getHelper()->getConfigData('passwordapi');
				$clientId = $this->getHelper()->getConfigData('ClientId');
				$xml = '<?xml version="1.0" encoding="UTF-8"?>
<CC5Request>
	<Name>'.$usernameapi.'</Name>
	<Password>'.$passwordapi.'</Password>
	<ClientId>'.$clientId.'</ClientId>
	<Type>PostAuth</Type>     
	<OrderId>'.$params_request["ReturnOid"].'</OrderId>
</CC5Request>';
			$url = $apigateway;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);

			// For xml, change the content-type.
			curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

			// Send to remote and return data to caller.
			curl_exec($ch);
			curl_close($ch);
			// Mage::app()->getResponse()->setRedirct(Mage::getUrl($this->getStoreManager()->getStore()->getBaseUrl() . 'cmiecom/index/success'));
			$this->getResponse()->setRedirect($this->getStoreManager()->getStore()->getBaseUrl() . 'cmiecom/index/success');
			$this->_redirect('cmiecom/index/success');
			}

                }else
                {
                    $this->changeStatusOrder($order, 'canceled', 'canceled', NULL, 'Transaction échouée');
                }
            }else
            {
                echo "FAILURE";
            }

        }else
        {
            echo 'No response from cmi!';
        }
    }


          

    private function deactiveCart(\Magento\Sales\Model\Order $order)
    {
        $mantener_carrito = $this->getHelper()->getConfigData('mantener_carrito');
        if ($mantener_carrito) {
            $quote = $this->getQuoteFactory()->create()->load($order->getQuoteId());
            $quote->setIsActive(false);
            $quote->setReservedOrderId($order->getIncrementId());
            $quote->save();
        }
    }

    private function addTransaction(\Magento\Sales\Model\Order $order, $data_trans)
    {
        $facturar = $this->getHelper()->getConfigData('facturar');
        if (!$facturar) {
            $payment = $order->getPayment();
            if (!empty($payment)) {
                $datetime = new \DateTime();
                $parent_trans_id = 'cmiecom_Payment';
                $payment->setTransactionId(htmlentities('cmiecom_Response_' . $datetime->getTimestamp()));
                $payment->setParentTransactionId($parent_trans_id);
                $payment->setTransactionAdditionalInfo(\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS, $data_trans);
                $payment->setIsTransactionClosed(true);
                $payment->addTransaction(\Magento\Sales\Model\Order\Payment\Transaction::TYPE_CAPTURE);
                $payment->save();
                $order->setPayment($payment);
                $order->save();
            }
        } else {
            $transactions = $this->getTransSearch()->create()->addOrderIdFilter($order->getId());
            if (!empty($transactions)) {

                foreach ($transactions->getItems() as $trans_item) {
                    if ($trans_item->getTxnType() === \Magento\Sales\Model\Order\Payment\Transaction::TYPE_CAPTURE) {
                        $res = $data_trans;
                        $additional_info = $trans_item->getAdditionalInformation(\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS);
                        if (!empty($additional_info) && is_array($additional_info)) {
                            $res = array_merge($additional_info, $data_trans);
                        }
                        $trans_item->setAdditionalInformation(\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS, $res);
                        $trans_item->save();
                    }
                }
            }
        }
    }

    private function getOrder($order_id)
    {
        $order = $this->getOrderFactory()->create();
        return $order->loadByIncrementId($order_id);
    }

    private function changeStatusOrder($order, $status, $state, $id_log = 0, $comment = '')
    {
        $msg = "CMI updated the order status with the value " . strtoupper($status);
        $order->setStatus($status);
        $order->setState($state);
        $order->addStatusHistoryComment($msg, $status);
        if (!empty($comment)) {
            $order->addStatusHistoryComment($comment, $status);
        }
        if ($state === 'canceled') {
            $order->registerCancellation("");
        }
        $order->save();
    }
}
