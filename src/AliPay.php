<?php
namespace silentlun\alipay;
/**
 * AliPay.php
 * @author: allen
 * @date  2020年4月30日上午11:42:48
 * @copyright  Copyright igkcms
 */

use yii\base\Exception;
use silentlun\alipay\lib\AopClient;
use silentlun\alipay\lib\AlipayTradeAppPayRequest;
use silentlun\alipay\lib\AlipayTradePagePayRequest;
use silentlun\alipay\lib\AlipayTradeWapPayRequest;

class AliPay extends AopClient
{
    public function __construct($alipay_config){
        $this->appId = $alipay_config['app_id'];
        $this->rsaPrivateKey = $alipay_config['merchant_private_key'];
        $this->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
        
        if(empty($this->appId)||trim($this->appId)==""){
            throw new Exception("appid should not be NULL!");
        }
        if(empty($this->rsaPrivateKey)||trim($this->rsaPrivateKey)==""){
            throw new Exception("private_key should not be NULL!");
        }
        if(empty($this->alipayrsaPublicKey)||trim($this->alipayrsaPublicKey)==""){
            throw new Exception("alipay_public_key should not be NULL!");
        }
        
    }
    
    /**
     * 创建电脑网站支付
     *@param:
     *@return:
     */
    public function createWebPay($order)
    {
        $request = new AlipayTradePagePayRequest();
        $bizcontent = [];
        $bizcontent['subject'] = $order['title'];
        $bizcontent['body'] = $order['body'];
        $bizcontent['out_trade_no'] = $order['trade_sn'];
        $bizcontent['total_amount'] = $order['total_fee'];
        $bizcontent['timeout_express'] = "90m";
        $bizcontent['product_code'] = "FAST_INSTANT_TRADE_PAY";
        $request->setNotifyUrl($order['notify_url']);
        $request->setReturnUrl($order['return_url']);
        $request->setBizContent(json_encode($bizcontent,JSON_UNESCAPED_UNICODE));
        $response = $this->pageExecute($request);
        return $response;
    }
    
    /**
     * 创建手机网站支付
     *@param:
     *@return:
     */
    public function createWapPay($order)
    {
        $request = new AlipayTradeWapPayRequest();
        $bizcontent = [];
        $bizcontent['subject'] = $order['title'];
        $bizcontent['body'] = $order['body'];
        $bizcontent['out_trade_no'] = $order['trade_sn'];
        $bizcontent['total_amount'] = $order['total_fee'];
        $bizcontent['timeout_express'] = "90m";
        $bizcontent['product_code'] = "QUICK_WAP_WAY";
        $request->setNotifyUrl($order['notify_url']);
        $request->setReturnUrl($order['return_url']);
        $request->setBizContent(json_encode($bizcontent,JSON_UNESCAPED_UNICODE));
        $response = $this->pageExecute($request);
        
        return $response;
    }
    
    /**
     * 创建APP支付
     *@param:
     *@return:
     */
    public function createAppPay($order)
    {
        $request = new AlipayTradeAppPayRequest();
        $bizcontent = [];
        $bizcontent['subject'] = $order['title'];
        $bizcontent['body'] = $order['body'];
        $bizcontent['out_trade_no'] = $order['trade_sn'];
        $bizcontent['total_amount'] = $order['total_fee'];
        $bizcontent['timeout_express'] = "90m";
        $bizcontent['product_code'] = "QUICK_MSECURITY_PAY";
        $request->setNotifyUrl($order['notify_url']);
        $request->setBizContent(json_encode($bizcontent,JSON_UNESCAPED_UNICODE));
        $response = $this->sdkExecute($request);
        
        return $response;
                         
    }

}