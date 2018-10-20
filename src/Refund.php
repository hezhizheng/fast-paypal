<?php
/**
 * Created by PhpStorm.
 * User: DexterHo
 * Date: 2018/10/20/0020
 * Time: 下午 23:20
 * Email: dexter.ho.cn@gmail.com
 */

namespace DexterHo\FastPayPal;

use PayPal\Api\Amount;
use PayPal\Api\Sale;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

require 'PayConfig.php';
require '../vendor/autoload.php';


class Refund
{

    public static function payPalRefundForTxnId(PayConfig $payConfig)
    {
        error_reporting(E_ALL ^ E_WARNING);
        try {
            $txn_id = $payConfig::$txn_id;
            $apiContext = new ApiContext(
                new OAuthTokenCredential(
                    $payConfig::$client_id,
                    $payConfig::$client_secret
                ));  // 这里是我们第一步拿到的数据

            if ($payConfig::$model === 'live') {
                $apiContext->setConfig(['mode' => 'live']);  // live下设置
            }

            $amt = new Amount();
            $amt->setCurrency($payConfig::$refund_currency_code)
                ->setTotal($payConfig::$refund_amount);  // 退款的费用

            $refund = new \PayPal\Api\Refund();
            $refund->setAmount($amt);

            $sale = new Sale();
            $sale->setId($txn_id);
            $refundedSale = $sale->refund($refund, $apiContext);

        } catch (\Exception $e) {
            // PayPal无效退款
            return json_decode(json_encode(['message' => $e->getMessage(), 'code' => $e->getCode(), 'state' => $e->getMessage()]));  // to object
        }
        // 退款完成
        return $refundedSale;
    }
}