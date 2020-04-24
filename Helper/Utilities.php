<?php

namespace cmi\cmiecom\Helper;

class Utilities extends \Magento\Framework\App\Helper\AbstractHelper
{

    private $vars_pay = null;

    private $ri = null;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Locale\ResolverInterface $ri
    ) {
        $this->ri = $ri;
        parent::__construct($context);
    }

    public function setParameter($key, $value)
    {
        $this->vars_pay[$key] = $value;
    }


    public function getIdiomaTpv()
    {
        $idioma_web = $this->ri->getLocale();
       
        return $idioma_web;
    }
    
    public function getParameter($key)
    {
        return $this->vars_pay[$key];
    }

    public function getParameters()
    {
        return $this->vars_pay;
    }

    /**
     * Encrypt 3DES
     *
     * @param  type $message
     * @param  type $key
     * @return type
     */
    private function encrypt3DES($message, $key)
    {

        $bytes = [0, 0, 0, 0, 0, 0, 0, 0];
        $iv = implode(array_map("chr", $bytes));

        $ciphertext = mcrypt_encrypt(MCRYPT_3DES, $key, $message, MCRYPT_MODE_CBC, $iv);
        return $ciphertext;
    }

    private function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    private function encodeBase64($data)
    {
        $data = base64_encode($data);
        return $data;
    }

    private function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    private function decodeBase64($data)
    {
        $data = base64_decode($data);
        return $data;
    }

    private function mac256($ent, $key)
    {
        $res = hash_hmac('sha256', $ent, $key, true);
        return $res;
    }

    public function generateIdLog()
    {
        $vars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringLength = strlen($vars);
        $result = '';
        for ($i = 0; $i < 20; $i++) {
            $result .= $vars[rand(0, $stringLength - 1)];
        }
        return $result;
    }

    public function getVersionClave()
    {
        return "HMAC_SHA256_V1";
    }


    public function getOrder()
    {
        $num_pedido = "";
        if (empty($this->vars_pay['DS_MERCHANT_ORDER'])) {
            $num_pedido = $this->vars_pay['Ds_Merchant_Order'];
        } else {
            $num_pedido = $this->vars_pay['DS_MERCHANT_ORDER'];
        }
        return $num_pedido;
    }

    public function arrayToJson()
    {
        $json = json_encode($this->vars_pay);
        return $json;
    }

    public function createMerchantParameters()
    {
        // Se transforma el array de datos en un objeto Json
        $json = $this->arrayToJson();
        // Se codifican los datos Base64
        return $this->encodeBase64($json);
    }

    public function getOrderNotif()
    {
        $num_pedido = "";
        if (empty($this->vars_pay['Ds_Order'])) {
            $num_pedido = $this->vars_pay['DS_ORDER'];
        } else {
            $num_pedido = $this->vars_pay['Ds_Order'];
        }
        return $num_pedido;
    }

    public function stringToArray($datosDecod)
    {
        $this->vars_pay = json_decode($datosDecod, true);
    }

    public function decodeMerchantParameters($datos)
    {
        // Se decodifican los datos Base64
        $decodec = $this->base64UrlDecode($datos);
        return $decodec;
    }

  
}
