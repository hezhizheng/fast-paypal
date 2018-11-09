<?php
/**
 * Description:
 * User: DexterHo
 * Date: 2018/11/9
 * Time: 10:44
 * Email: dexter.ho.cn@gmail.com
 * Created by PhpStorm.
 */

require '../../vendor/autoload.php';

use DexterHo\FastPayPal\PayConfig;
use DexterHo\FastPayPal\FastPayPal;
use DexterHo\FastPayPal\Notify;
use DexterHo\FastPayPal\Refund;

class FastPayPalTest
{
    private $pay_config;

    public function __construct()
    {
        $this->pay_config = new PayConfig;
    }

    /**
     * /demo/FastPayPalTest.php?method=pay
     */
    public function pay()
    {
        $this->pay_config->notify_url = 'http://paypal.xxxxx.com/demo/FastPayPalTest.php?method=notify';
        $this->pay_config->invoice = rand(100000000,999999999); // 订单号不能重复
        $pay = FastPayPal::redirectPay($this->pay_config);
        echo $pay; // 直接使用echo ！！！
    }

    /**
     * /demo/FastPayPalTest.php?method=notify
     * @return string
     */
    public function notify()
    {
        $paystatus = Notify::checkPaymentStatus(); // success or fail
        error_log('notify：'.json_encode($paystatus).PHP_EOL,3,date('Y-m-d').'.log');
        error_log('notify：'.json_encode($_REQUEST).PHP_EOL,3,date('Y-m-d').'.log');

        return $paystatus;
    }

    /**
     * /demo/FastPayPalTest.php?method=refund
     * @return array|\PayPal\Api\Refund
     */
    public function refund()
    {
        $this->pay_config->txn_id = '96F48113VU645933S';
        $res = Refund::payPalRefundForTxnId($this->pay_config); // 成功返回的是个对象
        error_log('refund：'.json_encode((array)$res).PHP_EOL,3,date('Y-m-d').'.log');
        return $res;
    }
}

$method = $_GET['method'];
$class = new FastPayPalTest;
//echo '<pre>;'.var_dump($class->$method());
var_dump($class->$method());