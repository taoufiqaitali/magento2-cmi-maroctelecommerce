<?php

namespace cmi\cmiecom\Controller\Index;

class Index extends \cmi\cmiecom\Controller\Index
{

    public function execute()
    {

        $Actionslk = trim($this->getHelper()->getConfigData('Actionslk'));
        $ClientId = trim($this->getHelper()->getConfigData('ClientId'));
        $callbackMode = trim($this->getHelper()->getConfigData('callback_mode'));
        $Secretkey = trim($this->getHelper()->getConfigData('Secretkey'));
        $auto_redirect = $this->getHelper()->getConfigData('auto_redirect');

        $order_id = $this->getCheckoutSession()->getLastRealOrderId();
        if (!empty($order_id)) {
            $_order = $this->getOrderFactory()->create();
            $_order->loadByIncrementId($order_id);
            $_order->setState(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
            $_order->setStatus(\Magento\Sales\Model\Order::STATE_PENDING_PAYMENT);
            $_order->save();



            $mantener_carrito = $this->getHelper()->getConfigData('mantener_carrito');
            if ($mantener_carrito) {
                $quote = $this->getQuoteFactory()->create()->load($_order->getQuoteId());
                $quote->setIsActive(true);
                $quote->setReservedOrderId(null);
                $quote->save();
                $this->getCheckoutSession()->setQuoteId($_order->getQuoteId());
            }


            $customer = $this->getCustomerSession()->getCustomer();


            $productos = '';

            $items = $_order->getAllVisibleItems();
            foreach ($items as $itemId => $item) {
                $productos .= $item->getName();
                $productos .= "X" . $item->getQtyToInvoice();
                $productos .= "/";
            }

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface'); //instance of StoreManagerInterface
            $baseCurrencyCode =  $storeManager->getStore()->getBaseCurrencyCode();
            $toCurrency1 = "MAD";
            $helperFactory = $objectManager->get('\Magento\Directory\Helper\Data');
            $price_converted = $helperFactory->currencyConvert($_order->getBaseGrandTotal(), $baseCurrencyCode, $toCurrency1);
            $transaction_amount = number_format($price_converted, 2, ',', '');

            $amountCur = number_format($_order->getGrandTotal(), 2, ',', '');
            $symbolCur = $storeManager->getStore()->getCurrentCurrencyCode();

            $numpedido = str_pad($order_id, 12, "0", STR_PAD_LEFT);
            $cantidad = (float) $transaction_amount;
            $titular = $customer->getFirstname() . " " .
            $customer->getMastname() . " " .
            $customer->getLastname() . "/ Correo:" .
            $customer->getEmail();


            $base_url = $this->getStoreManager()->getStore()->getBaseUrl();
            $urlcallback = $base_url . 'cmiecom/index/notify';
            $urlok = $base_url . 'cmiecom/index/success';
            $urlko = $base_url . 'cmiecom/index/cancel';
            $returnurl = $base_url . 'cmiecom/index/returnto';

            $lang = $this->getUtilities()->getIdiomaTpv();


            $data = array(
                'clientid' => $ClientId,
                'lang' => substr($lang, 0, 2),
                'rnd' => microtime(),
                'storetype' => "3DPAYHOSTING",
                'hashAlgorithm' => "ver3",
                'TranType' => "PreAuth",
                'email' => $_order->getCustomerEmail(),
                // 'BillToName' => $_order->getCustomerName(),
                'BillToName' =>  $this->str_without_accents($_order->getBillingAddress()->getName()),
                'BillToStreet1' =>  $this->str_without_accents($_order->getBillingAddress()->getStreet()[0]),
                // 'BillToStreet1' => $_order->getBillingAddress()->getStreet()[0],
                // 'BillToName' => preg_replace('/[^a-zA-Z0-9_ -]/s','',$_order->getBillingAddress()->getName()),
                // 'BillToStreet1' => preg_replace('/[^a-zA-Z0-9_ -]/s','',$_order->getBillingAddress()->getStreet()[0]),
                'BillToCity' => $this->str_without_accents($_order->getBillingAddress()->getCity()),
                'BillToCountry' => $this->str_without_accents($_order->getBillingAddress()->getCountryId()),
                'BillToTelVoice' => $_order->getBillingAddress()->getTelephone(),
                'oid' => $order_id,
                'amount' => $transaction_amount,
                'currency' => "504",
                'failUrl' => $urlko,
                'encoding' => "UTF-8",
                'shopurl' => $returnurl
            );
            if ($callbackMode == "1") {
                $data['AutoRedirect'] =  (($auto_redirect) ? "true" : "false");
                $data['okUrl'] = $urlcallback;
                $data['CallbackResponse'] = false;
            } else {
                $data['okUrl'] = $urlok;
                $data['AutoRedirect'] =  (($auto_redirect) ? "true" : "false");
                $data['CallbackResponse'] = true;
                $data['callbackUrl'] = $urlcallback;
            }

            if ($symbolCur != "MAD") {
                $data['amountCur'] = $amountCur;
                $data['symbolCur'] = $symbolCur;
            }
            $postParams = array();
            foreach ($data as $key => $value) {
                array_push($postParams, $key);
            }

            natcasesort($postParams);

            $hashval = "";

            foreach ($postParams as $param) {

                $paramValue = $data[$param];
                $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));
                $lowerParam = strtolower($param);
                if ($lowerParam != "hash" && $lowerParam != "encoding") {
                    $hashval = $hashval . $escapedParamValue . "|";
                }
            }
            $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $Secretkey));
            $hashval = $hashval . $escapedStoreKey;
            $calculatedHashValue = hash('sha512', $hashval);
            $hash = base64_encode (pack('H*',$calculatedHashValue));
            $data['hash'] = $hash;


            $form_cmiecom = '<form action="' . $Actionslk . '" method="post" id="cmiecom_form" name="cmiecom_form">';

            foreach ($data as $key => $value) {
                $form_cmiecom .= "<input type='hidden' name='" . $key . "' value='" . $value . "' />\n";
            }

            $form_cmiecom .= '</form>';
            $lang = substr($lang, 0, 2);
            if ($lang == "fr") {
                $form_cmiecom .= '<h3> Redirection en cours, merci de patienter </h3>';
            } elseif ($lang == "ar") {
                $form_cmiecom .= '<h3> إعادة التوجيه قيد التقدم ، يرجى الانتظار </h3>';
            } else {
                $form_cmiecom .= '<h3> Redirection in progress, please wait </h3>';
            }
            // var_dump($form_cmiecom);exit;
            $form_cmiecom .= '<script type="text/javascript">';
            $form_cmiecom .= 'document.cmiecom_form.submit();';
            $form_cmiecom .= '</script>';


            $this->addTransaction($_order, $data);

            $this->getResponse()->setBody($form_cmiecom);
            return;
        }
    }

    private function addTransaction(\Magento\Sales\Model\Order $order, $data_trans)
    {
        $payment = $order->getPayment();
        if (!empty($payment)) {
            $datetime = new \DateTime();
            $parent_trans_id = 'cmiecom_Payment';
            $payment->setTransactionId(htmlentities($parent_trans_id));
            $payment->setIsTransactionClosed(false);
            $payment->addTransaction(\Magento\Sales\Model\Order\Payment\Transaction::TYPE_ORDER);

            $payment->resetTransactionAdditionalInfo();

            $payment->setTransactionId(htmlentities('cmiecom_Request_' . $datetime->getTimestamp()));
            $payment->setParentTransactionId($parent_trans_id);
            $payment->setTransactionAdditionalInfo(\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS, $data_trans);
            $payment->setIsTransactionClosed(true);
            $payment->addTransaction(\Magento\Sales\Model\Order\Payment\Transaction::TYPE_AUTH);

            $payment->save();
            $order->setPayment($payment);
            $order->save();
        }
    }
    private function str_without_accents($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);
        $str = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $str);
        return $str;
    }
}
