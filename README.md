<p align="center">
    <a href="https://packagist.org/packages/dexterho/fast-paypal"><img src="https://img.shields.io/packagist/v/dexterho/fast-paypal.svg" alt="Version"></a>
    <a href="https://packagist.org/packages/dexterho/fast-paypal"><img src="https://img.shields.io/packagist/l/dexterho/fast-paypal.svg" alt="License"></a>
    <a href="https://github.com/hezhizheng/fast-paypal/tags"><img src="https://img.shields.io/github/tag/hezhizheng/fast-paypal.svg" alt="GitHub tag"></a>
</p>

# PayPal 支付、同步回调、异步回调、退款

## 安装
```
// 运行
composer require dexterho/fast-paypal
composer update -vvv
```
## 配置说明

```
    private $config_param = [
            /**
             * 支付参数
             */
            'url'                  => 'https://www.sandbox.paypal.com/cgi-bin/webscr', // Live https://www.paypal.com/cgi-bin/webscr
            'cmd'                  => '_xclick', // 告诉paypal 是立即购买
            'business'             => '920625788-facilitator@qq.com', // buy 920625788-buyer@qq.com, pwd 12345678
            'item_name'            => 'test', // 商品名称
            'item_number'          => 'test', // 商品编号
            'amount'               => '10', // 支付金额
            'currency_code'        => 'USD', //
            'return'               => 'http://xblog.frp.hezhizheng.com/paypal/sync',  // 同步回调地址
            'notify_url'           => 'http://xblog.frp.hezhizheng.com/paypal/async', // 异步回调地址，一定得外网可以访问到的！！！
            'cancel_return'        => 'https://hezhizheng.com', // 在支付界面取消返回商家的地址
            'invoice'              => '111111111111', // 订单号
            'charset'              => 'utf-8', // 字符集
            'no_shipping'          => '1', // 不要求客户提供收货地址
            'no_note'              => '1', // 付款说明
            'rm'                   => '2', // 没找到说明该参数的文档
    
    
            /**
             * 退款参数
             */
            'client_id'            => 'AbabXad3rTbKm35ryVfGDsZNnbqKx0TN-8pmH5euMinUZwpTr_mfoJDuYOJFuCxS0ZNkMI7FZbcZrNWY',
            'client_secret'        => 'EMRNMggmXW9spnkQ5DwOlqZ8vmDhSa1wwxRf6P84fjdUpyHTivaX5tJDNOSHoZi39OxwipsvqLR_hqdr',
            'refund_amount'        => '10',
            'refund_currency_code' => 'USD',
            'model'                => '', // live 环境下请将modle 的值设置为 live
            'txn_id'               => '', // 交易ID，异步回调可以获取到
        ];
```

## 支付

```
<?php
    use DexterHo\FastPayPal\FastPayPal;
    use DexterHo\FastPayPal\PayConfig;
    public function pay()
    {
        $this->pay_config->notify_url = 'http://paypal.xxxxx.com/demo/FastPayPalTest.php?method=notify';
        $this->pay_config->invoice = rand(100000000,999999999); // 订单号不能重复
        $pay = FastPayPal::redirectPay($this->pay_config);
        echo $pay; // 直接使用echo ！！！
    }
```
![image](https://raw.githubusercontent.com/hezhizheng/fast-paypal/master/pay-page.jpg)
## 异步回调(验证支付是否成功)

```
<?php
    use DexterHo\FastPayPal\PayConfig;
    use DexterHo\FastPayPal\Notify;
    public function notify()
    {
        $paystatus = Notify::checkPaymentStatus(); // success or fail
        error_log('notify：'.json_encode($paystatus).PHP_EOL,3,date('Y-m-d').'.log');
        error_log('notify：'.json_encode($_REQUEST).PHP_EOL,3,date('Y-m-d').'.log');

        return $paystatus;
    }
```

## 退款

```
<?php
    use DexterHo\FastPayPal\PayConfig;
    use DexterHo\FastPayPal\Refund;
    public function refund()
    {
        $this->pay_config->txn_id = '96F48113VU645933S';
        $res = Refund::payPalRefundForTxnId($this->pay_config); // 成功返回的是个对象
        error_log('refund：'.json_encode((array)$res).PHP_EOL,3,date('Y-m-d').'.log');
        return $res;
    }
```

## Demo/Test
- [Demo](https://github.com/hezhizheng/fast-paypal/blob/master/tests/demo/FastPayPalTest.php)
- [notify / refund 的数据结构](https://github.com/hezhizheng/fast-paypal/blob/master/tests/demo/2018-11-09.log)

## License

[MIT](./LICENSE)
